<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\support\Facades\Log;
use App\Services\ERPTokenService;
use App\Http\Requests\SalesOrderRequest;

class SalesOrderController extends Controller
{
    protected string $baseUrl = 'https://manjit.frappe.cloud/api/resource/Sales Order';
    protected $erpTokenService;

    public function __construct(ERPTokenService $erpTokenService)
    {
        $this->erpTokenService = $erpTokenService;
    }


    public function index()
    {

        $response = Http::withToken($this->accessToken())
            ->get($this->baseUrl, [
                'fields' => json_encode(["name", "customer_name", "order_type", "total_qty", "total"]),
                'limit_page_length' => 100
            ]);

        Log::channel('integrations')->info('Item List', ['response' => $response->json()]);
        $sales_orders = $response->json()['data'] ?? [];

        return view('sales_orders.index', compact('sales_orders'));
    }

    public function create()
    {
        return view('sales_orders.create');
    }
    public function store(SalesOrderRequest $request)
    {
        $payload = $request->validated();

        // Required default values
        $payload['doctype'] = "Sales Order";
        $payload['transaction_date'] = $payload['transaction_date'] ?? now()->format('Y-m-d');
        $payload['delivery_date'] = $payload['delivery_date'] ?? now()->addDays(1)->format('Y-m-d');

        $payload['company'] = $payload['company'] ?? "MANJIT (Demo)"; // your ERPNext company name
        $payload['currency'] = $payload['currency'] ?? "NPR";
        $payload['selling_price_list'] = $payload['selling_price_list'] ?? "Standard Selling";
        $payload['conversion_rate'] = $payload['conversion_rate'] ?? 1;

        // Make sure items are correct
        foreach ($payload['items'] as &$item) {
            $item['doctype'] = "Sales Order Item";
            $item['qty'] = (float) ($item['qty'] ?? 1);
            $item['rate'] = (float) ($item['rate'] ?? 0);
        }

        $response = Http::withToken($this->accessToken())
            ->post($this->baseUrl, $payload);

        Log::channel('integrations')->info('Sales Order Store API Response', [
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

        return redirect()->route('sales.index')
            ->with('success', 'Sales Order created successfully.');
    }

    public function show($name)
    {
        $response = Http::withToken($this->accessToken())
            ->get("{$this->baseUrl}/{$name}");

        $salesOrder = $response->json()['data'] ?? [];

        Log::channel('integrations')->info('Item Details', ['response' => $response->body()]);

        return view('sales_orders.show', compact('salesOrder'));
    }

    public function edit($name)
    {
        $response = Http::withToken($this->accessToken())
            ->get("{$this->baseUrl}/{$name}");

        $salesOrder = $response->json()['data'] ?? [];

        return view('sales_orders.create', compact('salesOrder'));
    }

    public function update(SalesOrderRequest $request, $name)
    {
        // Log::channel(('integrations'))->info('Update Item Name', ['name' => $name]);
        // Log::channel(('integrations'))->info('Update Item URL', ['url' => "{$this->baseUrl}/{$name}"]);
        Log::channel('integrations')->info('Update Item Request Data', ['request' => $request->validated()]);

        $encodedName = rawurlencode($name);

        $response = Http::withToken($this->accessToken())
            ->put("{$this->baseUrl}/{$encodedName}", $request->validated());

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


        return redirect()->route('sales.index')
            ->with('success', 'Item updated successfully.');
    }

    public function destroy($name)
    {
        Http::withToken($this->accessToken())
            ->delete("{$this->baseUrl}/{$name}");

        return redirect()->route('sales_orders.index')
            ->with('success', 'Item deleted successfully.');
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
