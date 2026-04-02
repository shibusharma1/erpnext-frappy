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
                'fields' => json_encode(["name","customer_name","order_type","total_qty","total"]),
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
        $response =  Http::withToken($this->accessToken())
            ->post($this->baseUrl, $request->validated());

        Log::channel('integrations')->info('Item Store API Response', [
            'status' => $response->status(),
            'success' => $response->successful(),
            'body' => $response->json(), // or $response->body()
        ]);

        return redirect()->route('sales_orders.index')
            ->with('success', 'Item created successfully.');
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
        Log::channel(('integrations'))->info('Update Item Name', ['name' => $name]);
        // Log::channel(('integrations'))->info('Update Item URL', ['url' => "{$this->baseUrl}/{$name}"]);
        Log::channel('integrations')->info('Update Item Request Data', ['request' => $request->validated()]);

        $encodedName = rawurlencode($name);

        $api_response = Http::withToken($this->accessToken())
            ->put("{$this->baseUrl}/{$encodedName}", $request->validated());

        Log::channel('integrations')->info('ERP Response', [
            'status' => $api_response->status(),
            'json'   => $api_response->json(),
        ]);

        return redirect()->route('sales_orders.index')
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
