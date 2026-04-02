<?php

namespace App\Services;

use App\Models\IntegrationAccount;
use Carbon\Carbon;

class IntegrationAccountService
{
    /**
     * Save OAuth token response for any provider.
     */
    public function saveTokenResponse(array $data): IntegrationAccount
    {
        /**
         * Required Keys:
         * company_id, user_id, provider
         * token_response => array containing access_token, refresh_token, expires_in etc
         */

        $tokenResponse = $data['token_response'];

        $expiresIn = $tokenResponse['expires_in'] ?? null;

        $accessTokenExpiresAt = $expiresIn
            ? Carbon::now()->addSeconds((int)$expiresIn)
            : null;

        return IntegrationAccount::updateOrCreate(
            [
                // Unique Condition (same as migration unique index)
                'company_id'       => $data['company_id'] ?? null,
                'provider'         => $data['provider'],
                'service_type'     => $data['service_type'] ?? null,
                'organization_id'  => $data['organization_id'] ?? null,
            ],
            [
                'user_id'      => $data['user_id'] ?? null,
                'account_id'   => $data['account_id'] ?? null,

                // Client config
                'client_id'     => $data['client_id'] ?? null,
                'client_secret' => $data['client_secret'] ?? null,

                'auth_url'     => $data['auth_url'] ?? null,
                'token_url'    => $data['token_url'] ?? null,
                'redirect_uri' => $data['redirect_uri'] ?? null,
                'api_base_url' => $data['api_base_url'] ?? null,

                // Tokens
                'access_token'  => $tokenResponse['access_token'] ?? null,
                'refresh_token' => $tokenResponse['refresh_token'] ?? null,
                'id_token'      => $tokenResponse['id_token'] ?? null,

                'token_type' => $tokenResponse['token_type'] ?? null,
                'scope'      => $tokenResponse['scope'] ?? null,

                // Expiry
                'expires_in'              => $expiresIn,
                'access_token_expires_at' => $accessTokenExpiresAt,

                // Save full raw response (important for debugging)
                'token_response' => $tokenResponse,

                // Additional settings/meta if needed
                'settings' => $data['settings'] ?? null,
                'meta'     => $data['meta'] ?? null,

                'is_active' => true,
                'revoked_at' => null,
            ]
        );
    }
}