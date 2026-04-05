<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Services\ERPNextApiService;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    protected ERPNextApiService $erp;
    protected string $doctype = "Customer";

    public function __construct(ERPNextApiService $erp)
    {
        $this->erp = $erp;
    }

    public function index()
    {
        $url = $this->erp->resource($this->doctype);

        $response = $this->erp->get($url, [
            'fields' => json_encode(["*"]),
            'limit_page_length' => 100
        ]);

        Log::channel('integrations')->info('Customer List', [
            'status' => $response->status(),
            'response' => $response->json()
        ]);

        $customers = $response->json()['data'] ?? [];

        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(CustomerRequest $request)
    {
        $url = $this->erp->resource($this->doctype);

        $response = $this->erp->post($url, $request->validated());

        if (!$response->successful()) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->erp->extractError($response));
        }

        return redirect()->route('customers.index')
            ->with('success', 'Customer created successfully.');
    }

    public function show($name)
    {
        $url = $this->erp->resource($this->doctype);

        $response = $this->erp->get("{$url}/" . rawurlencode($name));

        $customer = $response->json()['data'] ?? [];

        Log::channel('integrations')->info('Customer Details', [
            'status' => $response->status(),
            'response' => $response->json()
        ]);

        return view('customers.show', compact('customer'));
    }

    public function edit($name)
    {
        $url = $this->erp->resource($this->doctype);

        $response = $this->erp->get("{$url}/" . rawurlencode($name));

        $customer = $response->json()['data'] ?? [];

        return view('customers.create', compact('customer'));
    }

    public function update(CustomerRequest $request, $name)
    {
        $url = $this->erp->resource($this->doctype);

        Log::channel('integrations')->info('Update Customer Name', ['name' => $name]);
        Log::channel('integrations')->info('Update Customer Request Data', ['request' => $request->validated()]);

        $response = $this->erp->put("{$url}/" . rawurlencode($name), $request->validated());

        Log::channel('integrations')->info('ERP Update Response', [
            'status' => $response->status(),
            'json' => $response->json(),
        ]);

        if (!$response->successful()) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->erp->extractError($response));
        }

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    public function destroy($name)
    {
        $url = $this->erp->resource($this->doctype);

        $response = $this->erp->delete("{$url}/" . rawurlencode($name));

        if (!$response->successful()) {
            return redirect()->back()
                ->with('error', $this->erp->extractError($response));
        }

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }

    public function ping()
    {
        $response = $this->erp->get(config('erpnext.base_url') . "/api/v2/method/ping");

        Log::channel('integrations')->info('Ping Response', [
            'status' => $response->status(),
            'response' => $response->json()
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Ping successful',
            'data' => $response->json()
        ]);
    }
}