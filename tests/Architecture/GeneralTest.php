<?php

arch('Do not leave debug statements')
    ->expect(['dd', 'dump', 'var_dump'])
    ->not->toBeUsed();

arch('Do not use env helper in code')
    ->expect(['env'])
    ->not->toBeUsed();

arch('Actions classes should have handle method')
    ->expect('App\Actions')
    ->toBeClasses()
    ->toHaveMethod('handle');

arch('Events classes should have __construct method')
    ->expect('App\Events')
    ->toBeClasses()
    ->toHaveConstructor();

arch('Controllers classes should have proper suffix')
    ->expect('App\Controllers')
    ->toBeClasses()
    ->toHaveSuffix('Controller');

arch('Enums classes should be Enums')
    ->expect('App\Enums')
    ->toBeEnums();

arch('Models classes should extend Illuminate\Database\Eloquent\Model')
    ->expect('App\Models')
    ->toBeClasses()
    ->toExtend('Illuminate\Database\Eloquent\Model');

arch('Do not access session data in Async jobs')
    ->expect([
        'session',
        'auth',
        'request',
        'Illuminate\Support\Facades\Auth',
        'Illuminate\Support\Facades\Session',
        'Illuminate\Http\Request',
        'Illuminate\Support\Facades\Request'
    ])
    ->each->not->toBeUsedIn('App\Jobs');

arch('Jobs need to implement ShouldQueue')
    ->expect('App\Jobs')
    ->toImplement('Illuminate\Contracts\Queue\ShouldQueue');
