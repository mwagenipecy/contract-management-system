<?php



namespace App\Actions\Fortify;

use Laravel\Fortify\Actions\AttemptToAuthenticate as BaseAttemptToAuthenticate;
use Laravel\Fortify\Fortify;
use App\Services\TwoFactorEmailService;

class AttemptToAuthenticate extends BaseAttemptToAuthenticate
{
    protected $twoFactorEmailService;

    public function __construct(TwoFactorEmailService $twoFactorEmailService)
    {
        $this->twoFactorEmailService = $twoFactorEmailService;
    }

    public function handle($request, $next)
    {
        if (Fortify::$authenticateUsingCallback) {
            return $this->handleUsingCustomCallback($request, $next);
        }

        if ($this->guard->attempt(
            $request->only(Fortify::username(), 'password'),
            $request->boolean('remember'))
        ) {
            $user = $this->guard->user();

            // Check if user requires email 2FA
            if ($user->requiresTwoFactorEmail()) {
                // Send OTP
                $result = $this->twoFactorEmailService->sendOtp($user, $request->ip());
                
                if (!$result['success']) {
                    $this->guard->logout();
                    return redirect()->back()->withErrors(['email' => $result['message']]);
                }

                // Store user in session for 2FA verification
                session(['2fa_email_user_id' => $user->id]);
                $this->guard->logout();

                return redirect()->route('two-factor.email.challenge');
            }

            return $next($request);
        }

        $this->throwFailedAuthenticationException($request);
    }
}


