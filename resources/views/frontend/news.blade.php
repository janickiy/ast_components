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

    <div class="news container-md">
        <div class="news__feed">

            @if(count($newsBanner) > 0)
                <article class="news-banner">
                    <div class="news-banner__img">
                        <picture>
                            <img src="{{ $newsBanner[0]->getImage() }}"
                                 alt="{{ $newsBanner[0]->image_alt ?? $newsBanner[0]->title }}">
                        </picture>
                    </div>
                    <span class="news-banner__badge">акция</span>
                    <div class="news-banner__info">
                        <div>
                            <span class="news-banner__data">{{  $newsBanner[0]->dateFormat() }}</span>
                            <div class="news-banner__title">
                                <h2>{{ $newsBanner[0]->title }}</h2>
                            </div>
                            <p class="news-banner__description">{{ $newsBanner[0]->preview }}</p>
                        </div>
                        <a href="{{ route('frontend.news_item', ['slug' => $newsBanner[0]->slug]) }}"
                           class="news-banner__link btn btn--lg">
                            <span>Подробнее</span>
                            <svg aria-hidden="true">
                                <use xlink:href="{{ url('/images/sprite.svg#chevron-right') }}"></use>
                            </svg>
                        </a>
                    </div>
                </article>
            @endif

            @foreach($news ?? [] as $new)
                <article class="news-card">
                    @if($new->promotion == 1)
                        <span class="news-card__badge">акция</span>
                    @endif
                    <div class="news-card__img">
                        <picture>
                            <img src="{{ $new->getImage() }}" alt="{{ $new->image_alt ?? $new->title }}"
                                 title="{{ $new->image_title ?? $new->title }}" loading="lazy">
                        </picture>
                    </div>
                    <div class="news-card__info">
                        <div class="news-card__title">
                            <h3>{{ $new->title }}</h3>
                        </div>
                        <p class="news-card__description">{{ $new->preview }}</p>
                        <div class="news-card__footer">
                            <span class="news-card__data">{{ $new->dateFormat() }}</span>
                            <a href="{{ route('frontend.news_item',['slug' => $new->slug]) }}"
                               class="news-card__link btn btn--secondary">
                                <span>Подробнее</span>
                                <svg aria-hidden="true">
                                    <use xlink:href="{{ url('/images/sprite.svg#chevron-right') }}"></use>
                                </svg>
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach

        </div>

        {{ $news->links('layouts.frontend_pagination') }}

    </div>

@endsection

@section('js')

@endsection