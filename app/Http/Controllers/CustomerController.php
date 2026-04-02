<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\support\Facades\Log;
use App\Services\ERPTokenService;
use App\Http\Requests\CustomerRequest;

class CustomerController extends Controller
{
    protected string $baseUrl = 'https://manjit.frappe.cloud/api/resource/Customer';
    protected $erpTokenService;

    public function __construct(ERPTokenService $erpTokenService)
    {
        $this->erpTokenService = $erpTokenService;
    }


    public function index()
    {

        $response = Http::withToken($this->accessToken())
            ->get($this->baseUrl, [
                'fields' => json_encode(["*"]),
                'limit_page_length' => 100
            ]);


        $api_items = Http::withToken($this->accessToken())
            ->get($this->baseUrl, [
                'fields' => json_encode(["*"]),
                'limit_page_length' => 100
            ]);

        Log::channel('integrations')->info('Customer List', ['response' => $response->json()]);

        $customers = $response->json()['data'] ?? [];


        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(CustomerRequest $request)
    {
        Http::withToken($this->accessToken())
            ->post($this->baseUrl, $request->validated());

        return redirect()->route('customers.index')
            ->with('success', 'Customer created successfully.');
    }

    public function show($name)
    {
        $response = Http::withToken($this->accessToken())
            ->get("{$this->baseUrl}/{$name}");

        $customer = $response->json()['data'] ?? [];

        Log::channel('integrations')->info('Customer Details', ['response' => $response->body()]);

        return view('customers.show', compact('customer'));
    }

    public function edit($name)
    {
        $response = Http::withToken($this->accessToken())
            ->get("{$this->baseUrl}/{$name}");

        $customer = $response->json()['data'] ?? [];

        return view('customers.create', compact('customer'));
    }

    public function update(CustomerRequest $request, $name)
    {
        Log::channel(('integrations'))->info('Update Customer Name', ['name' => $name]);
        // Log::channel(('integrations'))->info('Update Customer URL', ['url' => "{$this->baseUrl}/{$name}"]);
        Log::channel('integrations')->info('Update Customer Request Data', ['request' => $request->validated()]);

        $encodedName = rawurlencode($name);

        $api_response = Http::withToken($this->accessToken())
            ->put("{$this->baseUrl}/{$encodedName}", $request->validated());

        // Log::channel('integrations')->info($api_response); 
        Log::channel('integrations')->info('ERP Response', [
            'status' => $api_response->status(),
            'json'   => $api_response->json(),
        ]);

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    public function destroy($name)
    {
        Http::withToken($this->accessToken())
            ->delete("{$this->baseUrl}/{$name}");

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
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

    public function ping()
    {

        $result = $this->erpTokenService->getToken();
        $response = Http::withToken($result['access_token'])->get('https://manjit.frappe.cloud/api/v2/method/ping');

        Log::channel('integrations')->info('Ping Response', ['response' => $response->json()]);

        return response()->json([
            'status' => 'success',
            'message' => 'Ping successful',
            'data' => $response->json()
        ]);
    }
}


// Note:
// 1. Both the encoded URL and normal URL will work same.
// 2. While fetching all the items in the index it will only render the name of the any DOCTYPE(Customer/Items/SalesOrder/PaymentInvoice)
// 3. So you need to add ?field=['name','customer_name','mobile_no','email_id'] or to fetch all field you can do ?filed=["*"]
// 4. Here name = id. Here name and customer_name are two different thing.Name=id whereas customer_name refers to the name that is used to displaying name of the customer