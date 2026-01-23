@extends('layouts.frontend')

@section('title', $title)

@section('description', $meta_description)

@section('keywords', $meta_keywords)

@section('seo_url_canonical', $seo_url_canonical)

@section('css')

@endsection

@section('content')

    <div class="page-header container-lg">
        <div class="page-header__wrap">

            @include('layouts._breadcrumbs')

            <h1>{{ $h1 }}</h1>

        </div>
    </div>

    <div class="manufacturers container-md">
        <ul class="manufacturers__list">
            @foreach($manufacturers ?? [] as $manufacturer)
                <li>
                    <article class="manufacture">
                        <div class="manufacture__title">
                            <h2>{{ $manufacturer->title }}</h2>
                        </div>
                        <span class="manufacture__country">{{ $manufacturer->country }}</span>
                        <div class="manufacture__img">
                            <picture>
                                <img src="{{ $manufacturer->getImage() }}" alt="{{ $manufacturer->title }}" loading="lazy">
                            </picture>
                        </div>
                        <a href="{{ route('frontend.manufacturer', ['slug' => $manufacturer->slug]) }}" class="manufacture__link btn btn--link">
                            <span>Подробнее</span>
                            <svg aria-hidden="true" class="orange">
                                <use xlink:href="{{ url('/images/sprite.svg#chevron-right') }}"></use>
                            </svg>
                        </a>
                    </article>
                </li>
            @endforeach
        </ul>
    </div>

    @include('layouts._watched_cards')

@endsection

@section('js')

@endsection