<?php

namespace App\Providers;

use App\Commons\ConstantsPool as P;
use App\Commons\Database\ConstantsPool as D;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Auth::viaRequest(
            P::CUSTOM_TOKEN,
            static fn(Request $request) => User
                ::where(D::REMEMBER_TOKEN, $request->header(P::CUSTOM_TOKEN))
                ->first()
        );

        $this->registerPolicies();
    }
}
