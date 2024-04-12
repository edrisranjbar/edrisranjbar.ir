<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use \Auth;

class DonationController extends Controller
{
    public function request(Request $request)
    {
        $validatedData = $request->validate([
            'amount' => 'required|integer|max:100000000'
        ]);

        // todo: get current user email if logged in
        $email = '';

        $response = zarinpal()
            ->amount($validatedData['amount'])
            ->request()
            ->description('حمایت مالی')
            ->callbackUrl('http://edrisranjbar.ir/donate/verify')
            ->email($email)
            ->send();

        if (!$response->success()) {
            return back()->with('error', $response->error()->message());
        }

        Transaction::create([
            'amount' => $validatedData['amount'],
            'Authority' => $response->authority()
        ]);

        return $response->redirect();
    }

    public function verify()
    {
        $authority = request()->query('Authority');
        $status = request()->query('Status');

        $transaction = Transaction::where(['Authority' => $authority]);

        $response = zarinpal()
            ->amount($transaction->amount)
            ->verification()
            ->authority($authority)
            ->send();

        if (!$response->success()) {
            return view('donate')->with('error', $response->error()->message());
        }

        $transaction->update([
            'Status' => $status,
            'referenceId' => $response->referenceId()
        ]);

        // todo: redirect to a thanks page
        return view('donate');
    }
}
