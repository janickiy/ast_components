<?php

use Illuminate\Support\Facades\Auth;

$client = Auth::guard('client')->user(); ?>

@if($client)
<button type="button" class="header__login-btn btn" data-modal-trigger="account">
    <svg aria-hidden="true" class="orange">
        <use xlink:href="{{ url('/images/sprite.svg#user') }}"></use>
    </svg>
    <span>{{ $client->name }}</span>
</button>
@else
<button type="button" class="header__login-btn btn" data-modal-trigger="login">
    <svg aria-hidden="true" class="orange">
        <use xlink:href="{{ url('/images/sprite.svg#user') }}"></use>
    </svg>
    <span>Вход/Регистрация</span>
</button>
@endif