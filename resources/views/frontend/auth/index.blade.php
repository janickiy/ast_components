@extends('layouts.frontend')

@section('title', $title)

@section('css')


@endsection

@section('content')

    <div class="error-hero container-lg">
        <div class="error-hero__wrap">
            <div class="modal__title">
                <h2>{{ $title }}</h2>
            </div>

            @if (session('success'))
                <p class="message-success">{{ session('success') }}</p>
            @endif

            <div class="error-hero__btn-wrap">
                <a href="{{ route('frontend.contacts.index') }}" class="btn btn--secondary">
                    <svg aria-hidden="true">
                        <use xlink:href="{{ url('/images/sprite.svg#phone') }}"></use>
                    </svg>
                    <span>Контакты</span>
                </a>
                <a href="{{ route('frontend.catalog') }}" class="btn btn--tertiary btn--lg">
                    <svg aria-hidden="true">
                        <use xlink:href="{{ url('/images/sprite.svg#catalog') }}"></use>
                    </svg>
                    <span>Каталог</span>
                </a>
                <a href="{{ url('/') }}" class="btn btn--secondary">
                    <span>На главную</span>
                    <svg aria-hidden="true">
                        <use xlink:href="{{ url('/images/sprite.svg#arrow-right') }}"></use>
                    </svg>
                </a>
            </div>
        </div>
    </div>

@endsection

@section('js')

@endsection
