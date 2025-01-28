<?php

namespace App\Http\Responses;

use App\Filament\Pages\Dashboard;
use Filament\Facades\Filament;
use Filament\Http\Responses\Auth\LoginResponse as BaseLoginResponse;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;
use App\Models\User;

class LoginResponse extends BaseLoginResponse
{
    public function toResponse($request): RedirectResponse | Redirector
    {

        if(auth()->user()->notAdmin()){
            return redirect()->to(Dashboard::getUrl(panel: 'user'));
        }
        return parent::toResponse($request);

        //return redirect()->intended(Filament::getUrl());
    }
}
