<?php

namespace App\Http\Controllers;

use App\Services\ApiOperatorClient;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiOperatorChatController extends Controller
{
    public function status(ApiOperatorClient $client): JsonResponse
    {
        if (! config('api_operator.enabled')) {
            return response()->json(['enabled' => false, 'healthy' => false]);
        }

        return response()->json([
            'enabled' => true,
            'healthy' => $client->isHealthy(),
        ]);
    }

    public function store(Request $request, ApiOperatorClient $client): JsonResponse
    {
        if (! config('api_operator.enabled')) {
            return response()->json(['message' => __('app.api_operator.disabled')], 503);
        }

        $data = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
            'session_id' => ['nullable', 'string', 'max:64'],
        ]);

        try {
            $response = $client->chat(
                message: $data['message'],
                sessionId: $data['session_id'] ?? null,
                user: $request->user(),
            );
        } catch (ConnectionException) {
            return response()->json(['message' => __('app.api_operator.unavailable')], 503);
        } catch (\Illuminate\Http\Client\RequestException $exception) {
            $detail = $exception->response?->json('detail') ?? $exception->getMessage();

            return response()->json(['message' => (string) $detail], 502);
        }

        return response()->json($response);
    }
}
