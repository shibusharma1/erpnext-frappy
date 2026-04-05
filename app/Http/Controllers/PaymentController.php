<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Services\ERPNextApiService;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected ERPNextApiService $erp;
    protected string $doctype = "Payment Entry";

    public function __construct(ERPNextApiService $erp)
    {
        $this->erp = $erp;
    }

    public function index()
    {
        $url = $this->erp->resource($this->doctype);

        $response = $this->erp->get($url, [
            'fields' => json_encode([
                "name",
                "payment_type",
                "party",
                "party_type",
                "paid_amount",
                "status"
            ]),
            'limit_page_length' => 100
        ]);

        Log::channel('integrations')->info('Payment List', [
            'status' => $response->status(),
            'response' => $response->json()
        ]);

        $payments = $response->json()['data'] ?? [];

        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        return view('payments.create');
    }

    public function store(PaymentRequest $request)
    {
        $url = $this->erp->resource($this->doctype);

        $payload = $request->validated();

        $payload['paid_amount'] = (float) $payload['paid_amount'];
        $payload['reference_no'] = $payload['reference_no'] ?? "BANK-TRX-0001";
        $payload['reference_date'] = $payload['reference_date'] ?? now()->format('Y-m-d');

        $payload['source_exchange_rate'] = $payload['source_exchange_rate'] ?? 1;
        $payload['target_exchange_rate'] = $payload['target_exchange_rate'] ?? 1;

        $response = $this->erp->post($url, $payload);

        Log::channel('integrations')->info('Payment Store API Response', [
            'status' => $response->status(),
            'success' => $response->successful(),
            'body' => $response->json(),
            'payload' => $payload
        ]);

        if (!$response->successful()) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->erp->extractError($response));
        }

        return redirect()->route('payments.index')
            ->with('success', 'Payment created successfully.');
    }

    public function show($name)
    {
        $url = $this->erp->resource($this->doctype);

        $response = $this->erp->get("{$url}/" . rawurlencode($name));

        $payment = $response->json()['data'] ?? [];

        Log::channel('integrations')->info('Payment Details', [
            'status' => $response->status(),
            'response' => $response->json()
        ]);

        return view('payments.show', compact('payment'));
    }

    public function edit($name)
    {
        $url = $this->erp->resource($this->doctype);

        $response = $this->erp->get("{$url}/" . rawurlencode($name));

        $payment = $response->json()['data'] ?? [];

        return view('payments.create', compact('payment'));
    }

    public function update(PaymentRequest $request, $name)
    {
        $url = $this->erp->resource($this->doctype);

        Log::channel('integrations')->info('Update Payment Name', ['name' => $name]);
        Log::channel('integrations')->info('Update Payment Request Data', [
            'request' => $request->validated()
        ]);

        $payload = $request->validated();

        $payload['paid_amount'] = (float) $payload['paid_amount'];
        $payload['reference_no'] = $payload['reference_no'] ?? "BANK-TRX-0001";
        $payload['reference_date'] = $payload['reference_date'] ?? now()->format('Y-m-d');

        $payload['source_exchange_rate'] = $payload['source_exchange_rate'] ?? 1;
        $payload['target_exchange_rate'] = $payload['target_exchange_rate'] ?? 1;

        $response = $this->erp->put("{$url}/" . rawurlencode($name), $payload);

        Log::channel('integrations')->info('ERP Payment Update Response', [
            'status' => $response->status(),
            'json' => $response->json(),
        ]);

        if (!$response->successful()) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->erp->extractError($response));
        }

        return redirect()->route('payments.index')
            ->with('success', 'Payment updated successfully.');
    }

    public function destroy($name)
    {
        $url = $this->erp->resource($this->doctype);

        $response = $this->erp->delete("{$url}/" . rawurlencode($name));

        if (!$response->successful()) {
            return redirect()->back()
                ->with('error', $this->erp->extractError($response));
        }

        return redirect()->route('payments.index')
            ->with('success', 'Payment deleted successfully.');
    }
}