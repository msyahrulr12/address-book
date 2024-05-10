<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Service\AuditTrailService;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    public function responseSuccess($data = [], $message = 'Success')
    {
        return response()->json([
            'success' => true,
            'code' => '00',
            'http_code' => 200,
            'message' => $message,
            'data' => $data,
            'errors' => [],
        ], 200);
    }

    /**
     * @param \App\Results\ErrorCollection[] $errors
     */
    public function responseFailed($errors = [], $code = 400, $message = 'Failed')
    {
        $parseErrors = [];
        foreach ($errors as $error) {
            if (is_object($error)) {
                $parseErrors[] = $error->toArray();
            } else {
                $parseErrors[] = $error;
            }

        }

        return response()->json([
            'success' => true,
            'code' => '99',
            'http_code' => $code,
            'message' => $message,
            'data' => [],
            'errors' => $parseErrors,
        ], $code);
    }

    /**
     * @return \App\Models\User
     */
    public function getUser()
    {
        return Auth::user();
    }

    /**
     * @param string $activity
     *
     * @return void
     */
    public function writeAuditTrail(string $activity)
    {
        AuditTrailService::saveActivity($activity);

        return;
    }
}
