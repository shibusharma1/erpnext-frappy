<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalesOrderRequest;
use App\Services\ERPNextApiService;
use Illuminate\Support\Facades\Log;

class SalesOrderController extends Controller
{
    protected ERPNextApiService $erp;
    protected string $doctype = "Sales Order";

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
                "customer_name",
                "order_type",
                "total_qty",
                "total"
            ]),
            'limit_page_length' => 100
        ]);

        Log::channel('integrations')->info('Sales Order List', [
            'status' => $response->status(),
            'response' => $response->json()
        ]);

        $sales_orders = $response->json()['data'] ?? [];

        return view('sales_orders.index', compact('sales_orders'));
    }

    public function create()
    {
        return view('sales_orders.create');
    }

    public function store(SalesOrderRequest $request)
    {
        $url = $this->erp->resource($this->doctype);

        $payload = $request->validated();

        // Required default values
        $payload['doctype'] = "Sales Order";
        $payload['transaction_date'] = $payload['transaction_date'] ?? now()->format('Y-m-d');
        $payload['delivery_date'] = $payload['delivery_date'] ?? now()->addDays(1)->format('Y-m-d');

        $payload['company'] = $payload['company'] ?? "MANJIT (Demo)";
        $payload['currency'] = $payload['currency'] ?? "NPR";
        $payload['selling_price_list'] = $payload['selling_price_list'] ?? "Standard Selling";
        $payload['conversion_rate'] = $payload['conversion_rate'] ?? 1;

        // Items setup
        if (!empty($payload['items']) && is_array($payload['items'])) {
            foreach ($payload['items'] as &$item) {
                $item['doctype'] = "Sales Order Item";
                $item['qty'] = (float) ($item['qty'] ?? 1);
                $item['rate'] = (float) ($item['rate'] ?? 0);
            }
        }

        $response = $this->erp->post($url, $payload);

        Log::channel('integrations')->info('Sales Order Store API Response', [
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

        return redirect()->route('sales.index')
            ->with('success', 'Sales Order created successfully.');
    }

    public function show($name)
    {
        $url = $this->erp->resource($this->doctype);

        $response = $this->erp->get("{$url}/" . rawurlencode($name));

        $salesOrder = $response->json()['data'] ?? [];

        Log::channel('integrations')->info('Sales Order Details', [
            'status' => $response->status(),
            'response' => $response->json()
        ]);

        return view('sales_orders.show', compact('salesOrder'));
    }

    public function edit($name)
    {
        $url = $this->erp->resource($this->doctype);

        $response = $this->erp->get("{$url}/" . rawurlencode($name));

        $salesOrder = $response->json()['data'] ?? [];

        return view('sales_orders.create', compact('salesOrder'));
    }

    public function update(SalesOrderRequest $request, $name)
    {
        $url = $this->erp->resource($this->doctype);

        Log::channel('integrations')->info('Update Sales Order', [
            'name' => $name,
            'request' => $request->validated()
        ]);

        $payload = $request->validated();

        // Optional: if items exist, force proper typecasting
        if (!empty($payload['items']) && is_array($payload['items'])) {
            foreach ($payload['items'] as &$item) {
                $item['doctype'] = "Sales Order Item";
                $item['qty'] = (float) ($item['qty'] ?? 1);
                $item['rate'] = (float) ($item['rate'] ?? 0);
            }
        }

        $response = $this->erp->put("{$url}/" . rawurlencode($name), $payload);

        Log::channel('integrations')->info('ERP Sales Order Update Response', [
            'status' => $response->status(),
            'json' => $response->json(),
        ]);

        if (!$response->successful()) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->erp->extractError($response));
        }

        return redirect()->route('sales.index')
            ->with('success', 'Sales Order updated successfully.');
    }

    public function destroy($name)
    {
        $url = $this->erp->resource($this->doctype);

        $response = $this->erp->delete("{$url}/" . rawurlencode($name));

        if (!$response->successful()) {
            return redirect()->back()
                ->with('error', $this->erp->extractError($response));
        }

        return redirect()->route('sales.index')
            ->with('success', 'Sales Order deleted successfully.');
    }
}