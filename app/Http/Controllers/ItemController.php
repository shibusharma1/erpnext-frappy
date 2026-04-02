<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\support\Facades\Log;
use App\Services\ERPTokenService;
use App\Http\Requests\ItemRequest;

class ItemController extends Controller
{
    protected string $baseUrl = 'https://manjit.frappe.cloud/api/resource/Item';
    protected $erpTokenService;

    // protected function headers()
    // {
    //     return [
    //         'Accept' => 'application/json',
    //         // Add Authorization if needed
    //     ];
    // }


    public function __construct(ERPTokenService $erpTokenService)
    {
        $this->erpTokenService = $erpTokenService;
    }


    public function index()
    {

        $response = Http::withToken($this->accessToken())
            ->get($this->baseUrl, [
                'fields' => json_encode(["name", "item_code", "item_name", "standard_rate", "valuation_rate", "last_purchase_rate"]),
                'limit_page_length' => 100
            ]);


        Log::channel('integrations')->info('Item List', ['response' => $response->json()]);

        $items = $response->json()['data'] ?? [];

        return view('items.index', compact('items'));
    }

    public function create()
    {
        return view('items.create');
    }

    public function store(ItemRequest $request)
    {
        $response =  Http::withToken($this->accessToken())
            ->post($this->baseUrl, $request->validated());

        Log::channel('integrations')->info('Item Store API Response', [
            'status' => $response->status(),
            'success' => $response->successful(),
            'body' => $response->json(), // or $response->body()
        ]);

        return redirect()->route('items.index')
            ->with('success', 'Item created successfully.');
    }

    public function show($name)
    {
        $response = Http::withToken($this->accessToken())
            ->get("{$this->baseUrl}/{$name}");

        $item = $response->json()['data'] ?? [];

        Log::channel('integrations')->info('Item Details', ['response' => $response->body()]);

        return view('items.show', compact('item'));
    }

    public function edit($name)
    {
        $response = Http::withToken($this->accessToken())
            ->get("{$this->baseUrl}/{$name}");

        $item = $response->json()['data'] ?? [];

        return view('items.create', compact('item'));
    }

    public function update(ItemRequest $request, $name)
    {
        Log::channel(('integrations'))->info('Update Item Name', ['name' => $name]);
        // Log::channel(('integrations'))->info('Update Item URL', ['url' => "{$this->baseUrl}/{$name}"]);
        Log::channel('integrations')->info('Update Item Request Data', ['request' => $request->validated()]);



        // $api_response = Http::withToken($this->accessToken())
        //     ->put("{$this->baseUrl}/{name}", $request->validated());

        $encodedName = rawurlencode($name);

        $api_response = Http::withToken($this->accessToken())
            ->put("{$this->baseUrl}/{$encodedName}", $request->validated());

        // Log::channel('integrations')->info($api_response); 
        Log::channel('integrations')->info('ERP Response', [
            'status' => $api_response->status(),
            'json'   => $api_response->json(),
        ]);

        return redirect()->route('items.index')
            ->with('success', 'Item updated successfully.');
    }

    public function destroy($name)
    {
        Http::withToken($this->accessToken())
            ->delete("{$this->baseUrl}/{$name}");

        return redirect()->route('items.index')
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

        // $response = Http::withToken($accessToken)->get('https://manjit.frappe.cloud/api/resource/Item/Shibu Sharma');

        // Log::channel('integration')->info('ERP Action Result', ['response' => $response->json()]);

        return $accessToken;
    }
}
