<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\TwoFactorLoginResponse as TwoFactorLoginResponseContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TwoFactorLoginResponse implements TwoFactorLoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();
        
        // Check if user has email 2FA enabled
        if ($user->requiresTwoFactorEmail()) {
            return $request->wantsJson()
                ? new JsonResponse(['two_factor_email' => true], 200)
                : redirect()->intended(config('fortify.home'));
        }

        return $request->wantsJson()
            ? new JsonResponse('', 204)
            : redirect()->intended(config('fortify.home'));
    }
}


