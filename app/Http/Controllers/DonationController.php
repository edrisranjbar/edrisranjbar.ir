<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Donation;
use Illuminate\Http\Request;
use \Auth;

class DonationController extends Controller
{
    public function request(Request $request)
    {
        $validatedData = $request->validate([
            'amount' => 'required|integer|max:100000000|min:1000',
            'name' => 'nullable|max:20',
            'description'=> 'nullable|max:255',
        ]);

        // todo: get current user email if logged in
        $email = '';

        $response = zarinpal()
            ->amount($validatedData['amount'])
            ->request()
            ->description('حمایت مالی' . $validatedData['name'])
            ->callbackUrl('https://edrisranjbar.ir/donate/verify')
            ->email($email)
            ->send();

        if (!$response->success()) {
            return back()->with('error', $response->error()->message());
        }

        $authority = $response->authority();
        Transaction::create([
            'amount' => $validatedData['amount'],
            'Authority' => $authority
        ]);
        $donation = Donation::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'amount' => $validatedData['amount'],
        ]);
        session(['donation_id' => $donation->id]);

        return $response->redirect();
    }

    public function verify()
    {
        $authority = request()->query('Authority');
        $status = request()->query('Status');

        $transaction = Transaction::firstWhere(['Authority' => $authority]);

        if (!$transaction) {
            return redirect('donate')->with('error', 'کد اعتبارسنجی نامتعبر است.');
        }

        $response = zarinpal()
            ->amount($transaction->amount)
            ->verification()
            ->authority($authority)
            ->send();

        if (!$response->success()) {
            return redirect('donate')->with('error', $response->error()->message());
        }

        $transaction->update([
            'Status' => $status,
            'referenceId' => $response->referenceId()
        ]);
        $donation = Donation::findOrFail(session('donation_id'));
        $donation->update([
            'transaction_id' => $response->referenceId(),
            'status' => 'completed'
        ]);
        session()->forget('donation_id');
        // todo: redirect to a thanks page
        return view('donate')->with('success', 'پرداخت با موفقیت انجام شد');
    }
}
