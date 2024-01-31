<?php

namespace App\Filament\Auth;

use Filament\Pages\Auth\Login as BaseAuth;

class Login extends BaseAuth
{
    public function mount(): void
    {
        parent::mount();

        $this->form->fill([
            'email' => 'demo@demo.com',
            'password' => '12345678',
            'remember' => true,
        ]);
    }
}
