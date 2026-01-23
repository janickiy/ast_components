@extends('layouts.frontend')

@section('title', $title)

@section('description', $meta_description)

@section('keywords', $meta_keywords)

@section('seo_url_canonical', $seo_url_canonical)

@section('css')

@endsection

@section('content')

    <div class="manufacturer-hero container-lg">
        <div class="manufacturer-hero__wrap">
            <div class="manufacturer-hero__container">

                @include('layouts._breadcrumbs')

                <div class="manufacturer-hero__content">
                    <div class="manufacturer-hero__title">
                        <h1>{{ $h1 }}</h1>
                    </div>
                    <div class="manufacturer-hero__info">
                        <div class="manufacturer-hero__logo">
                            <div class="manufacturer-hero__logo-wrap">
                                <img src="{{ $manufacturer->getImage() }}" alt="{{ $manufacturer->title }}">
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
                </div>
            </div>
        </div>
    </div>

    @if(count($otherCatalogs) > 0)
        <section class="manufacture-catalog container-md">
            <div class="manufacture-catalog__title">
                <h2>Компонеты {{ $manufacturer->title }}, представленные в&nbsp;каталоге</h2>
            </div>
            <ul class="manufacture-catalog__list">
                @foreach($otherCatalogs as $catalog)
                    <li class="manufacture-catalog__item">
                        <h3>{{ $catalog->name }}</h3>
                        <div class="manufacture-catalog__item-footer">
                            <span class="manufacture-catalog__item-count">{{ $catalog?->getProductCount() }} товаров</span>
                            <a href="{{ route('frontend.catalog', ['slug' => $catalog->slug]) }}"
                               class="manufacture-catalog__item-link btn btn--secondary btn--sm">
                                <span>В каталог</span>
                                <svg aria-hidden="true">
                                    <use xlink:href="{{ url('/images/sprite.svg#arrow-right') }}"></use>
                                </svg>
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>
        </section>
    @endif

    @include('layouts._watched_cards')

@endsection

@section('js')

@endsection
