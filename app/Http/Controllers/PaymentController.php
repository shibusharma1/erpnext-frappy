<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\support\Facades\Log;
use App\Services\ERPTokenService;
use App\Http\Requests\PaymentRequest;

class PaymentController extends Controller
{
    protected string $baseUrl = 'https://manjit.frappe.cloud/api/resource/Payment Entry';
    protected $erpTokenService;

    public function __construct(ERPTokenService $erpTokenService)
    {
        $this->erpTokenService = $erpTokenService;
    }


    public function index()
    {

        $response = Http::withToken($this->accessToken())
            ->get($this->baseUrl, [
                'fields' => json_encode(["name", "payment_type", "party", "party_type", "paid_amount", "status"]),
                'limit_page_length' => 100
            ]);

        // $response = Http::withToken($this->accessToken())
        //     ->get($this->baseUrl, [
        //         'fields' => json_encode(["*"]),
        //         'limit_page_length' => 100
        //     ]);

        // return $response->json();
        Log::channel('integrations')->info('Payment List', ['response' => $response->json()]);

        $payments = $response->json()['data'] ?? [];

        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        return view('payments.create');
    }

    // public function store(PaymentRequest $request)
    // {
    //     $response =  Http::withToken($this->accessToken())
    //         ->post($this->baseUrl, $request->validated());

    //     Log::channel('integrations')->info('Payment Store API Response', [
    //         'status' => $response->status(),
    //         'success' => $response->successful(),
    //         'body' => $response->json(), // or $response->body()
    //     ]);

    //     // ✅ If ERPNext update failed
    //     if (!$response->successful()) {

    //         $errorMessage = $response->json()['exception'] ?? 'Something went wrong';

    //         // ERPNext message comes inside _server_messages
    //         if (!empty($response->json()['_server_messages'])) {
    //             $serverMessages = json_decode($response->json()['_server_messages'], true);

    //             if (!empty($serverMessages[0])) {
    //                 $decodedMessage = json_decode($serverMessages[0], true);

    //                 if (!empty($decodedMessage['message'])) {
    //                     $errorMessage = strip_tags($decodedMessage['message']); // remove <strong>
    //                 }
    //             }
    //         }

    //         return redirect()->back()
    //             ->withInput()
    //             ->with('error', $errorMessage);
    //     }


    //     return redirect()->route('payments.index')
    //         ->with('success', 'Payment created successfully.');
    // }
    public function store(PaymentRequest $request)
    {
        $payload = $request->validated();
        $payload['paid_amount'] = (float) $payload['paid_amount'];
        $payload["reference_no"] = "BANK-TRX-0001";
        $payload['reference_date'] = now()->format('Y-m-d');
        // $payload['docstatus'] = 1;
        // $payload['status'] ="Submitted";
        // $payload['received_amount'] = (float) $payload['received_amount'];
        // Add default exchange rates
        $payload['source_exchange_rate'] = $payload['source_exchange_rate'] ?? 1;
        $payload['target_exchange_rate'] = $payload['target_exchange_rate'] ?? 1;

        $response = Http::withToken($this->accessToken())
            ->post($this->baseUrl, $payload);

        Log::channel('integrations')->info('Payment Store API Response', [
            'status' => $response->status(),
            'success' => $response->successful(),
            'body' => $response->json(),
            'payload' => $payload
        ]);

        if (!$response->successful()) {

            $errorMessage = $response->json()['exception'] ?? 'Something went wrong';

            if (!empty($response->json()['_server_messages'])) {
                $serverMessages = json_decode($response->json()['_server_messages'], true);

                if (!empty($serverMessages[0])) {
                    $decodedMessage = json_decode($serverMessages[0], true);

                    if (!empty($decodedMessage['message'])) {
                        $errorMessage = strip_tags($decodedMessage['message']);
                    }
                }
            }

            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
        }

        return redirect()->route('payments.index')
            ->with('success', 'Payment created successfully.');
    }
    public function show($name)
    {
        $response = Http::withToken($this->accessToken())
            ->get("{$this->baseUrl}/{$name}");

        $payment = $response->json()['data'] ?? [];

        Log::channel('integrations')->info('Payment Details', ['response' => $response->body()]);

        return view('payments.show', compact('payment'));
    }

    public function edit($name)
    {
        $response = Http::withToken($this->accessToken())
            ->get("{$this->baseUrl}/{$name}");

        $payment = $response->json()['data'] ?? [];

        return view('payments.create', compact('payment'));
    }

    public function update(PaymentRequest $request, $name)
    {
        Log::channel(('integrations'))->info('Update Payment Name', ['name' => $name]);
        Log::channel('integrations')->info('Update Payment Request Data', ['request' => $request->validated()]);

        $payload = $request->validated();
        $payload['paid_amount'] = (float) $payload['paid_amount'];
        $payload["reference_no"] = "BANK-TRX-0001";
        $payload['reference_date'] = now()->format('Y-m-d');
        // $payload['docstatus'] = 1;
        // $payload['status'] ="Submitted";
        // $payload['received_amount'] = (float) $payload['received_amount'];
        // Add default exchange rates
        $payload['source_exchange_rate'] = $payload['source_exchange_rate'] ?? 1;
        $payload['target_exchange_rate'] = $payload['target_exchange_rate'] ?? 1;

        $encodedName = rawurlencode($name);

        $response = Http::withToken($this->accessToken())
            ->put("{$this->baseUrl}/{$encodedName}", $payload);

        // Log::channel('integrations')->info($response); 
        Log::channel('integrations')->info('ERP Response', [
            'status' => $response->status(),
            'json'   => $response->json(),
        ]);

        // ✅ If ERPNext update failed
        if (!$response->successful()) {

            $errorMessage = $response->json()['exception'] ?? 'Something went wrong';

            // ERPNext message comes inside _server_messages
            if (!empty($response->json()['_server_messages'])) {
                $serverMessages = json_decode($response->json()['_server_messages'], true);

                if (!empty($serverMessages[0])) {
                    $decodedMessage = json_decode($serverMessages[0], true);

                    if (!empty($decodedMessage['message'])) {
                        $errorMessage = strip_tags($decodedMessage['message']); // remove <strong>
                    }
                }
            }

            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
        }

        return redirect()->route('payments.index')
            ->with('success', 'Payment updated successfully.');
    }

    public function destroy($name)
    {
        Http::withToken($this->accessToken())
            ->delete("{$this->baseUrl}/{$name}");

        return redirect()->route('payments.index')
            ->with('success', 'Payment deleted successfully.');
    }

    private function accessToken()
    {
        $result = $this->erpTokenService->getToken();

        if (!$result['success']) {
            return response()->json([
                'status' => 'error',
                'message' => $result['message']
            ], 400);
        }

        $accessToken = $result['access_token'];
        return $accessToken;
    }
}
