<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;

class DonationController extends Controller
{
    /**
     * Create a new payment for donation
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function pay(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1000',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'message' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'لطفاً اطلاعات را به درستی وارد کنید',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Get validated data
            $data = $validator->validated();
            
            // Create donation record
            $donation = Donation::create([
                'name' => $data['name'] ?? 'ناشناس',
                'email' => $data['email'] ?? null,
                'message' => $data['message'] ?? null,
                'amount' => $data['amount'],
                'currency' => 'T', // Toman
                'payment_method' => 'zarinpal',
                'status' => 'pending',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Create invoice
            $invoice = new Invoice;
            $invoice->amount((int)$data['amount']);
            $invoice->detail('donor', $donation->id);
            
            // Purchase the invoice and get the payment form
            $paymentRef = Payment::callbackUrl(route('donations.verify'))
                ->purchase(
                    $invoice,
                    function($driver, $transactionId) use ($donation) {
                        // Store the transaction ID
                        $donation->update([
                            'transaction_id' => $transactionId
                        ]);
                    }
                );
            
            // Get the payment form (Zarinpal returns a RedirectionForm here)
            $redirectForm = $paymentRef->pay();
            
            // For Zarinpal, we need to get the action from the redirection form
            $paymentUrl = $redirectForm->getAction();
            
            // Check if payment URL is empty
            if (empty($paymentUrl)) {
                Log::error('Payment URL is empty', [
                    'donation_id' => $donation->id,
                    'redirect_form' => $redirectForm,
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'خطا در اتصال به درگاه پرداخت. لطفاً مجدد تلاش کنید.',
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'در حال انتقال به درگاه پرداخت...',
                'payment_url' => $paymentUrl,
                'donation_id' => $donation->id,
            ]);

        } catch (\Exception $e) {
            Log::error('Donation payment error: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'خطا در اتصال به درگاه پرداخت. لطفاً مجدد تلاش کنید.',
            ], 500);
        }
    }

    /**
     * Verify the payment
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request)
    {
        try {
            // Find related donation by Authority - handle both Authority and authority (case-insensitive)
            $authority = $request->Authority ?? $request->authority ?? '';
            
            if (empty($authority)) {
                return response()->json([
                    'success' => false,
                    'message' => 'اطلاعات پرداخت ناقص است'
                ], 400);
            }
            
            $donation = Donation::where('transaction_id', $authority)->first();

            // Check if donation exists
            if (!$donation) {
                return response()->json([
                    'success' => false,
                    'message' => 'اطلاعات پرداخت یافت نشد.'
                ], 404);
            }

            // Get Status from request - handle both Status and status (case-insensitive)
            $status = $request->Status ?? $request->status ?? '';
            
            // Convert status to uppercase for consistency
            $status = strtoupper($status);

            // Check Status (if payment was successful)
            if ($status !== 'OK') {
                $donation->update([
                    'status' => 'failed'
                ]);

                // If the request was from a browser, redirect to frontend
                if ($request->header('Accept') && str_contains($request->header('Accept'), 'text/html')) {
                    $frontendUrl = config('app.frontend_url', 'http://localhost:5173');
                    return redirect()->to("{$frontendUrl}/donation/success?status=failed&authority={$authority}");
                }

                return response()->json([
                    'success' => false,
                    'message' => 'پرداخت ناموفق یا لغو شده توسط کاربر.'
                ]);
            }

            // Verify payment if successful
            $receipt = Payment::amount($donation->amount)
                ->transactionId($authority)
                ->verify();

            // Get reference ID
            $refId = $receipt->getReferenceId();

            // Update donation
            $donation->update([
                'status' => 'paid',
                'ref_id' => $refId
            ]);

            // Format donation amount with Persian numerals for response
            $formattedAmount = number_format($donation->amount) . ' تومان';
            
            // If the request was from a browser, redirect to frontend
            if ($request->header('Accept') && str_contains($request->header('Accept'), 'text/html')) {
                $frontendUrl = config('app.frontend_url', 'http://localhost:5173');
                return redirect()->to("{$frontendUrl}/donation/success?status=success&authority={$authority}");
            }

            return response()->json([
                'success' => true,
                'message' => 'پرداخت شما با موفقیت انجام شد. از حمایت شما سپاسگزاریم.',
                'donation' => [
                    'id' => $donation->id,
                    'amount' => $formattedAmount,
                    'ref_id' => $refId,
                    'created_at' => $donation->created_at->format('Y-m-d H:i:s')
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Payment verification error: ' . $e->getMessage(), ['exception' => $e]);
            return $this->paymentError('خطا در بررسی پرداخت: ' . $e->getMessage());
        }
    }
    
    /**
     * Return error response for payment
     * 
     * @param string $message
     * @param Donation|null $donation
     * @return \Illuminate\Http\Response
     */
    private function paymentError($message, Donation $donation = null)
    {
        $response = [
            'success' => false,
            'message' => $message
        ];
        
        if ($donation) {
            $response['donation'] = [
                'id' => $donation->id,
                'amount' => $donation->formatted_amount,
                'status' => $donation->status_in_persian,
            ];
        }
        
        return response()->json($response);
    }
}
