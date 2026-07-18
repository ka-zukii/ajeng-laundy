<?php

namespace App\Http\Controllers;

use App\Services\Pembayaran\MidtransCallbackService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MidtransCallbackController extends Controller
{
    public function __invoke(
        Request $request,
        MidtransCallbackService $callbackService,
    ): JsonResponse {
        $callbackService->handle($request);

        return response()->json([
            'success' => true,
        ]);
    }
}
