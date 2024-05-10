<?php

namespace App\Http\Middleware;

use App\Models\Application;
use Closure;
use Illuminate\Http\Request;

class AuthenticateClientApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $headerXSignature = $request->headers->get('X-Signature');
        if (!$headerXSignature) {
            return response()->json([
                'success' => true,
                'code' => '99',
                'http_code' => 400,
                'message' => 'Request not valid!',
                'data' => [],
                'errors' => [
                    'x-signature' => __('message.x_signature.empty', [], 'id')
                ],
            ], 400);
        }

        $timestamp = $request->headers->get('Timestamp');
        if (!$timestamp) {
            return response()->json([
                'success' => true,
                'code' => '99',
                'http_code' => 400,
                'message' => 'Request not valid!',
                'data' => [],
                'errors' => [
                    'x-signature' => __('message.timestamp.empty', [], 'id')
                ],
            ], 400);
        }

        list($clientId, $xSignature) = explode(':', $headerXSignature);

        if (!$clientId || !$xSignature) {
            return response()->json([
                'success' => true,
                'code' => '99',
                'http_code' => 400,
                'message' => 'Request not valid!',
                'data' => [],
                'errors' => [
                    'x-signature' => __('message.x_signature.invalid_format', [], 'id')
                ],
            ], 400);
        }

        $application = Application::where('client_id', '=', $clientId)->first();
        if (!$application) {
            return response()->json([
                'success' => true,
                'code' => '99',
                'http_code' => 400,
                'message' => 'Request not valid!',
                'data' => [],
                'errors' => [
                    'client_id' => __('message.client_id.not_found', [], 'id')
                ],
            ], 400);
        }

        $generatedSignature = hash_hmac('sha256', $clientId.$timestamp, $application->secret_key);

        if ($generatedSignature != $xSignature) {
            return response()->json([
                'success' => true,
                'code' => '99',
                'http_code' => 400,
                'message' => 'Request not valid!',
                'data' => [],
                'errors' => [
                    'x-signature' => __('message.x_signature.wrong_signature', [], 'id')
                ],
            ], 400);
        }

        return $next($request);
    }
}
