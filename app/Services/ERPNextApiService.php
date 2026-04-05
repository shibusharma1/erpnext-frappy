<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ERPNextApiService
{
    protected ERPTokenService $tokenService;
    protected string $baseUrl;

    public function __construct(ERPTokenService $tokenService)
    {
        $this->tokenService = $tokenService;
        $this->baseUrl = config('erpnext.base_url');
    }

    private function token(): string
    {
        $result = $this->tokenService->getToken();

        if (!$result['success']) {
            throw new \Exception($result['message']);
        }

        return $result['access_token'];
    }

    public function resource(string $doctype): string
    {
        return "{$this->baseUrl}/api/resource/{$doctype}";
    }

    public function get(string $url, array $params = [])
    {
        return Http::withToken($this->token())->get($url, $params);
    }

    public function post(string $url, array $data = [])
    {
        return Http::withToken($this->token())->post($url, $data);
    }

    public function put(string $url, array $data = [])
    {
        return Http::withToken($this->token())->put($url, $data);
    }

    public function delete(string $url)
    {
        return Http::withToken($this->token())->delete($url);
    }

    public function extractError($response): string
    {
        $json = $response->json();

        $errorMessage = $json['exception'] ?? 'Something went wrong';

        if (!empty($json['_server_messages'])) {
            $serverMessages = json_decode($json['_server_messages'], true);

            if (!empty($serverMessages[0])) {
                $decodedMessage = json_decode($serverMessages[0], true);

                if (!empty($decodedMessage['message'])) {
                    $errorMessage = strip_tags($decodedMessage['message']);
                }
            }
        }

        return $errorMessage;
    }
}