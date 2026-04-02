<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ERPTokenService
{
    protected $baseUrl;
    protected $clientId;
    protected $clientSecret;

    public function __construct()
    {
        $this->baseUrl = config('erpnext.base_url'); // e.g., https://manjit.frappe.cloud
        $this->clientId = config('erpnext.client_id');
        $this->clientSecret = config('erpnext.client_secret');
    }

    /**
     * Get valid access token
     */
    public function getToken()
    {
        $tokenRecord = DB::table('integration_accounts')->first();

        if (!$tokenRecord) {
            return ['success' => false, 'message' => 'DB does not have token'];
        }

        $expiresAt = Carbon::parse($tokenRecord->access_token_expires_at);
        $now = Carbon::now();

        // Check if token is expired
        if ($now->gte($expiresAt)) {
            Log::info('ERP Token expired. Refreshing...');
            $refreshResult = $this->refreshToken($tokenRecord->refresh_token);

            if (!$refreshResult['success']) {
                return $refreshResult; // return error message
            }

            return ['success' => true, 'access_token' => $refreshResult['access_token']];
        }

        return ['success' => true, 'access_token' => $tokenRecord->access_token];
    }

    /**
     * Refresh ERP token using refresh token
     */
    protected function refreshToken($refreshToken)
    {
        try {
            $response = Http::asForm()->post("https://manjit.frappe.cloud/api/method/frappe.integrations.oauth2.get_token", [
                'grant_type' => 'refresh_token',
                'refresh_token' => $refreshToken,
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ]);

            if ($response->failed()) {
                Log::error('Failed to refresh ERP token', ['response' => $response->body()]);
                return ['success' => false, 'message' => 'Failed to refresh ERP token'];
            }

            $data = $response->json();

            // Save the new token in DB
            DB::table('integration_accounts')->updateOrInsert(
                ['id' => 1], // assuming single record
                [
                    'access_token' => $data['access_token'],
                    'refresh_token' => $data['refresh_token'],
                    'access_token_expires_at' => Carbon::now()->addSeconds($data['expires_in']),
                    'updated_at' => Carbon::now(),
                ]
            );

            return ['success' => true, 'access_token' => $data['access_token']];
        } catch (\Exception $e) {
            Log::error('Exception while refreshing ERP token', ['error' => $e->getMessage()]);
            return ['success' => false, 'message' => 'Exception while refreshing ERP token'];
        }
    }
}