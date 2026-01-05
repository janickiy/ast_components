@extends('layouts.frontend')

@section('title', $title)

@section('description', $meta_description)

@section('keywords', $meta_keywords)

@section('seo_url_canonical', $seo_url_canonical)

@section('content')

    @include('layouts._breadcrumbs')

    <div class="profile container-sm">
        <div class="profile__header">
            <h1>{{ $h1 }}</h1>
        </div>

        @if (session('success'))
            <div class="alert alert--success">
                <svg aria-hidden="true">
                    <use xlink:href="{{ url('/images/sprite.svg#check-circle') }}"></use>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="profile__content">
            <div class="profile__info">
                <div class="profile__info-row">
                    <div class="profile__info-label">
                        <svg aria-hidden="true" class="orange">
                            <use xlink:href="{{ url('/images/sprite.svg#user') }}"></use>
                        </svg>
                        <span>Имя:</span>
                    </div>
                    <div class="profile__info-value">{{ $user->name ?: 'Не указано' }}</div>
                </div>
                <div class="profile__info-row">
                    <div class="profile__info-label">
                        <svg aria-hidden="true" class="orange">
                            <use xlink:href="{{ url('/images/sprite.svg#mail') }}"></use>
                        </svg>
                        <span>Email:</span>
                    </div>
                    <div class="profile__info-value">{{ $user->email }}</div>
                </div>
                <div class="profile__info-row">
                    <div class="profile__info-label">
                        <svg aria-hidden="true" class="orange">
                            <use xlink:href="{{ url('/images/sprite.svg#time') }}"></use>
                        </svg>
                        <span>Дата регистрации:</span>
                    </div>
                    <div class="profile__info-value">{{ $user->created_at->format('d.m.Y') }}</div>
                </div>
            </div>

            <div class="profile__actions">
                <a href="{{ route('frontend.profile.edit') }}" class="btn btn--secondary">
                    <svg aria-hidden="true">
                        <use xlink:href="{{ url('/images/sprite.svg#edit') }}"></use>
                    </svg>
                    <span>Редактировать профиль</span>
                </a>
                <a href="{{ route('frontend.profile.password.edit') }}" class="btn btn--secondary">
                    <svg aria-hidden="true">
                        <use xlink:href="{{ url('/images/sprite.svg#lock') }}"></use>
                    </svg>
                    <span>Сменить пароль</span>
                </a>
                <form action="{{ route('frontend.auth.logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn--tertiary">
                        <svg aria-hidden="true">
                            <use xlink:href="{{ url('/images/sprite.svg#logout') }}"></use>
                        </svg>
                        <span>Выйти</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection
