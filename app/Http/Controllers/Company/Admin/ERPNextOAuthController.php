<?php


namespace App\Http\Controllers\Company\Admin;

use App\Services\IntegrationAccountService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

use Log;

class ERPNextOAuthController extends Controller
{
    private $baseUrl = 'https://manjit.frappe.cloud';
    // private $domain = 'manjit.frappe.cloud';
    private $clientId;
    private $clientSecret;

    public function __construct()
    {
        $this->clientId = env('ERPNEXT_CLIENT_ID');
        $this->clientSecret = env('ERPNEXT_CLIENT_SECRET');
    }

    /** 
     * Show the OAuth popup page
     */
    public function showAuthPopup(Request $request, $domain = 'null')
    {
        $codeVerifier = $this->generateCodeVerifier();
        $codeChallenge = $this->generateCodeChallenge($codeVerifier);

        Session::put('erpnext_code_verifier', $codeVerifier);

        $redirectUri = url("/admin/erpnext/callback");

        Log::info($redirectUri);

        $params = [
            'client_id' => $this->clientId,
            'response_type' => 'code',
            'scope' => 'openid all',
            'redirect_uri' => $redirectUri,
            'state' => csrf_token(),
            'code_challenge' => $codeChallenge,
            'code_challenge_method' => 'S256'
        ];

        $queryString = http_build_query($params, '', '&', PHP_QUERY_RFC3986);
        $authUrl = $this->baseUrl . '/api/method/frappe.integrations.oauth2.authorize?' . $queryString;


        Log::info($redirectUri);

        return view('company.erpnext.erpnext-oauth', compact('authUrl', 'domain', 'redirectUri'));
    }

    /**
     * Handle the OAuth callback - Changed to handle GET request
     */
    public function callback(Request $request, $domain = null)
    {

        $service = app(IntegrationAccountService::class);

        try {
            $code = $request->query('code');
            $state = $request->query('state');
            $error = $request->query('error');
            $errorDescription = $request->query('error_description');

            \Log::info('ERPNext Callback Received', [
                'code_exists' => !empty($code),
                'state' => $state,
                'error' => $error,
                'domain' => $domain,
                'all_params' => $request->all()
            ]);

            if ($error) {
                \Log::error('ERPNext OAuth Error', [
                    'error' => $error,
                    'description' => $errorDescription
                ]);

                return $this->renderCallbackResponse([
                    'success' => false,
                    'error' => $error,
                    'message' => $errorDescription ?? 'Authentication failed'
                ]);
            }

            if ($state !== csrf_token()) {
                \Log::error('Invalid state parameter', [
                    'received' => $state,
                    'expected' => csrf_token()
                ]);

                return $this->renderCallbackResponse([
                    'success' => false,
                    'error' => 'invalid_state',
                    'message' => 'Invalid state parameter'
                ]);
            }

            $codeVerifier = Session::get('erpnext_code_verifier');

            if (!$codeVerifier) {
                return $this->renderCallbackResponse([
                    'success' => false,
                    'error' => 'no_verifier',
                    'message' => 'Code verifier not found'
                ]);
            }

            $redirectUri = url("/admin/erpnext/callback");


            Log::info($redirectUri);

            $response = Http::asForm()->post($this->baseUrl . '/api/method/frappe.integrations.oauth2.get_token', [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'code' => $code,
                'grant_type' => 'authorization_code',
                'redirect_uri' => $redirectUri,
                'code_verifier' => $codeVerifier
            ]);

            \Log::info('ERPNext Token Response', [
                'respose' => $response,
                'status' => $response->status(),
                'body' => $response->json()
            ]);


            \Log::channel('integrations')->info("Before DB Token Response", [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);


            if ($response->successful()) {
                $tokens = $response->json();

                Session::put('erpnext_access_token', $tokens['access_token']);
                // Session::put('erpnext_refresh_token', $tokens['refresh_token'] ?? null);
                // Session::put('erpnext_token_expires_in', $tokens['expires_in'] ?? null);
                // Session::put('erpnext_token_obtained_at', time());

                // Session::forget('erpnext_code_verifier');
                $account = $service->saveTokenResponse([
                    'company_id' => 1,
                    'user_id' => 1,

                    'provider' => 'erpnext',
                    'service_type' => 'erpnext_cloud',

                    'organization_id' => 'demo_company_123',

                    'client_id' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                    'redirect_uri' => 'http://127.0.0.1:8000/callback',
                    'api_base_url' => 'https://manjit.frappe.cloud',

                    'token_response' => $tokens,

                    'settings' => [
                        'accounts_url' => 'https://manjit.frappe.cloud',
                    ],
                ]);

                \Log::channel('integrations')->info("After DB insertion Token Response", [
                    'status' => $response->status(),
                    'body' => $response->json(),
                ]);


                return $this->renderCallbackResponse([
                    'success' => true,
                    'message' => 'Successfully authenticated with ERPNext'
                ]);
            }

            return $this->renderCallbackResponse([
                'success' => false,
                'error' => 'token_exchange_failed',
                'message' => 'Failed to get access token',
                'details' => $response->json()
            ]);
        } catch (\Exception $e) {
            \Log::error('ERPNext OAuth Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return $this->renderCallbackResponse([
                'success' => false,
                'error' => 'exception',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Render callback response for popup
     */
    private function renderCallbackResponse($data)
    {

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json($data);
        }

        $html = '<!DOCTYPE html>
        <html>
        <head>
            <title>ERPNext Authentication</title>
            <script>
                // Send message to parent window
                window.opener.postMessage(' . json_encode($data) . ', window.location.origin);
                // Close popup after a short delay
                setTimeout(function() {
                    window.close();
                }, 1000);
            </script>
        </head>
        <body>
            <p>' . ($data['success'] ? 'Authentication successful! Closing window...' : 'Authentication failed: ' . ($data['message'] ?? 'Unknown error')) . '</p>
        </body>
        </html>';

        return response($html);
    }

    /**
     * Generate a random code verifier for PKCE
     */
    private function generateCodeVerifier($length = 64)
    {
        return rtrim(strtr(base64_encode(random_bytes($length)), '+/', '-_'), '=');
    }

    /**
     * Generate code challenge from verifier using S256 method
     */
    private function generateCodeChallenge($codeVerifier)
    {
        return rtrim(strtr(base64_encode(hash('sha256', $codeVerifier, true)), '+/', '-_'), '=');
    }

    /**
     * Test API call with the access token
     */
    public function testApi(Request $request, $domain)
    {
        $accessToken = Session::get('erpnext_access_token');

        if (!$accessToken) {
            return response()->json(['error' => 'Not authenticated'], 401);
        }

        $response = Http::withToken($accessToken)
            ->get($this->baseUrl . '/api/resource/Item', [
                'limit_page_length' => 10
            ]);

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json([
            'error' => 'API call failed',
            'details' => $response->json()
        ], $response->status());
    }

   

    /**
     * Disconnect/Logout from ERPNext
     */
    public function disconnect(Request $request, $domain = null)
    {
        Session::forget([
            'erpnext_access_token',
            'erpnext_refresh_token',
            'erpnext_token_expires_in',
            'erpnext_token_obtained_at',
            'erpnext_code_verifier'
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Disconnected from ERPNext successfully');
    }
}
