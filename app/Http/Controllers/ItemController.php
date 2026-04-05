<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Services\ERPNextApiService;
use Illuminate\Support\Facades\Log;

class ItemController extends Controller
{
    protected ERPNextApiService $erp;
    protected string $doctype = "Item";

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
                "item_code",
                "item_name",
                "standard_rate",
                "valuation_rate",
                "last_purchase_rate",
                "item_group"
            ]),
            'limit_page_length' => 100
        ]);

        Log::channel('integrations')->info('Item List', [
            'status' => $response->status(),
            'response' => $response->json()
        ]);

        $items = $response->json()['data'] ?? [];

        return view('items.index', compact('items'));
    }

    public function create()
    {
        return view('items.create');
    }

    public function store(ItemRequest $request)
    {
        $url = $this->erp->resource($this->doctype);

        $response = $this->erp->post($url, $request->validated());

        Log::channel('integrations')->info('Item Store API Response', [
            'status' => $response->status(),
            'success' => $response->successful(),
            'body' => $response->json(),
        ]);

        if (!$response->successful()) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->erp->extractError($response));
        }

        return redirect()->route('items.index')
            ->with('success', 'Item created successfully.');
    }

    public function show($name)
    {
        $url = $this->erp->resource($this->doctype);

        $response = $this->erp->get("{$url}/" . rawurlencode($name));

        $item = $response->json()['data'] ?? [];

        Log::channel('integrations')->info('Item Details', [
            'status' => $response->status(),
            'response' => $response->json()
        ]);

        return view('items.show', compact('item'));
    }

    public function edit($name)
    {
        $url = $this->erp->resource($this->doctype);

        $response = $this->erp->get("{$url}/" . rawurlencode($name));

        $item = $response->json()['data'] ?? [];

        return view('items.create', compact('item'));
    }

    public function update(ItemRequest $request, $name)
    {
        $url = $this->erp->resource($this->doctype);

        Log::channel('integrations')->info('Update Item Name', ['name' => $name]);
        Log::channel('integrations')->info('Update Item Request Data', [
            'request' => $request->validated()
        ]);

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

        return redirect()->route('items.index')
            ->with('success', 'Item updated successfully.');
    }

    public function destroy($name)
    {
        $url = $this->erp->resource($this->doctype);

        $response = $this->erp->delete("{$url}/" . rawurlencode($name));

        if (!$response->successful()) {
            return redirect()->back()
                ->with('error', $this->erp->extractError($response));
        }

        return redirect()->route('items.index')
            ->with('success', 'Item deleted successfully.');
    }
}