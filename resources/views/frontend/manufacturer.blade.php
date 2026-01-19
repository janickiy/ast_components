@extends('layouts.frontend')

@section('title', $title)

@section('description', $meta_description)

@section('keywords', $meta_keywords)

@section('seo_url_canonical', $seo_url_canonical)

@section('css')

@endsection

@section('content')

    @include('layouts._breadcrumbs')

    <div class="manufacturer-hero__info">
        <div class="manufacturer-hero__logo">
            <div class="manufacturer-hero__logo-wrap">
                <picture>
                    <img src="{{ $manufacturer->getImage() }}" alt="{{ $manufacturer->title }}">
                </picture>
            </div>
            <a href="{{ url('/images/logo.svg') }}" download="logo.svg" class="manufacturer-hero__logo-btn btn btn--tertiary btn--lg">
                <svg aria-hidden="true">
                    <use xlink:href="{{ url('/images/sprite.svg#download') }}"></use>
                </svg>
                <span>Скачать сертификат</span>
            </a>
        </div>
        <div class="manufacturer-hero__description">
           {!! $manufacturer->description !!}
        </div>
    </div>

    <section class="manufacture-catalog container-md">
        <div class="manufacture-catalog__title">
            <h2>Компонеты {{ $manufacturer->title }}, представленные в&nbsp;каталоге</h2>
        </div>
        <ul class="manufacture-catalog__list">
        </ul>
    </section>

    @include('layouts._watched_cards')

@endsection

@section('js')

@endsection
