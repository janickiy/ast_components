@extends('layouts.frontend')

@section('title', $title)

@section('description', $meta_description)

@section('keywords', $meta_keywords)

@section('seo_url_canonical', $seo_url_canonical)

@section('css')


@endsection

@section('content')

    @include('layouts._breadcrumbs')

    <div class="news container-md">
        <div class="news__feed">

            @foreach($news ?? [] as $new)

                <article class="news-card">
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

@endsection

@section('js')



@endsection