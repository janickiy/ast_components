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

    <div class="news-item container-xs">
        <picture>
            <img src="{{ $news->getImage() }}" alt="{{ $news->image_alt }}" title="{{ $news->image_title }}" class="news-item__img">
        </picture>
        <div class="news-item__content">
            <div class="news-item__content-wrap">
                {!! $news->text !!}
            </div>
        </div>
    </div>
    <section class="other-news">
        <div class="container-md">
            <div class="section-title">
                <h2>Другие события и&nbsp;обновления</h2>
            </div>
            <div class="other-news-slider swiper">
                <div class="swiper-wrapper">

                    @foreach($lastNews ?? [] as $news)
                        <div class="swiper-slide">
                            <article class="news-card">
                                @if($news->promotion == 1) <span class="news-card__badge">акция</span> @endif
                                <div class="news-card__img">
                                    <picture>
                                        <img src="{{ $news->getImage() }}" alt="{{ $news->image_alt }}" title="{{ $news->image_title }}" loading="lazy">
                                    </picture>
                                </div>
                                <div class="news-card__info">
                                    <div class="news-card__title">
                                        <h3>Новый склад в Москве</h3>
                                    </div>
                                    <p class="news-card__description">{{ $news->preview }}</p>
                                    <div class="news-card__footer">
                                        <span class="news-card__data">{{ $news->dateFormat() }}</span>
                                        <a href="{{ route('frontend.news_item',['slug' => $news->slug]) }}" class="news-card__link btn btn--secondary">
                                            <span>Подробнее</span>
                                            <svg aria-hidden="true">
                                                <use xlink:href="{{ url('/images/sprite.svg#chevron-right') }}"></use>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach

                </div>

                <div class="swiper-button-prev">
                    <svg aria-hidden="true" class="orange">
                        <use xlink:href="{{ url('/images/sprite.svg#chevron-left') }}"></use>
                    </svg>
                </div>
                <div class="swiper-button-next">
                    <svg aria-hidden="true" class="orange">
                        <use xlink:href="{{ url('/images/sprite.svg#chevron-right') }}"></use>
                    </svg>
                </div>

            </div>
        </div>
    </section>

@endsection

@section('js')

@endsection
