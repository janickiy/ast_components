@extends('layouts.frontend')

@section('title', $title)

@section('description', $meta_description)

@section('keywords', $meta_keywords)

@section('seo_url_canonical', $seo_url_canonical)

@section('css')


@endsection

@section('content')

    <div class="error-hero container-lg">
        <div class="error-hero__wrap">
            <img src="{{ url('/images/404.svg') }}" alt="" aria-hidden="true" class="error-hero__img">
            <div class="error-hero__title">
                <h1>Страница не&nbsp;найдена</h1>
            </div>
            <p class="error-hero__desc">К сожалению, запрашиваемая страница отсутствует или была удалена.<br> Но вы можете перейти на главную, в каталог продукции или связаться с&nbsp;нами.</p>
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
