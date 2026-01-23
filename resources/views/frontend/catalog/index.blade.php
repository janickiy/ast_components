@extends('layouts.frontend')

@section('title', $title)

@section('description', $meta_description)

@section('keywords', $meta_keywords)

@section('seo_url_canonical', $seo_url_canonical)

@section('css')
    <style>
        .product-card {
            display: -ms-grid;
            display: grid;
            -webkit-box-align: start;
            -ms-flex-align: start;
            align-items: flex-start;
            -ms-grid-columns: auto 2.4rem auto 2.4rem auto;
            grid-template-columns: repeat(3, auto);
            -webkit-column-gap: 2.4rem;
            -moz-column-gap: 2.4rem;
            column-gap: 2.4rem;
            padding: 2.4rem;
            background-color: #fff;
            border-radius: .8rem;
        }
    </style>
@endsection

@section('content')

    <div class="page-header container-lg">
        <div class="page-header__wrap">
            @include('layouts._breadcrumbs')

            <h1>{{ $h1 }}</h1>
            <p class="page-header__text"></p>
        </div>
    </div>

    <div class="catalog container-md js-catalog">
        <div class="catalog__filters">
            <button type="button" class="catalog__filters-close-btn btn btn--icon btn--sm js-close-filters-btn">
                <svg aria-hidden="true">
                    <use xlink:href="{{ url('/images/sprite.svg#close') }}"/>
                </svg>
            </button>
            <div class="catalog__filters-title">
                <h2>Фильтры</h2>
            </div>

            <div class="catalog__filters-accordions accordions">
                <div class="accordion__item">
                    <button class="catalog__accordion-btn accordion__btn js-accordion-btn" aria-expanded="true">
                        <span class="accordion__title">Товарная группа</span>
                        <svg aria-hidden="true" class="orange">
                            <use xlink:href="{{ url('/images/sprite.svg#chevron-down') }}"></use>
                        </svg>
                    </button>
                    <div class="accordion__content">
                        <div class="catalog__filters-list">
                            <div class="catalog__filters-checkbox form-checkbox">
                                <input type="checkbox" id="product-group-1" checked>
                                <label for="product-group-1">
                                    <span>Микроконтроллеры</span>
                                    <sup class="catalog__item-count">100</sup>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion__item">
                    <button class="catalog__accordion-btn accordion__btn js-accordion-btn" aria-expanded="true">
                        <span class="accordion__title">Наличие</span>
                        <svg aria-hidden="true" class="orange">
                            <use xlink:href="{{ url('/images/sprite.svg#chevron-down') }}"></use>
                        </svg>
                    </button>
                    <div class="accordion__content">
                        <div class="catalog__filters-list">
                            <div class="catalog__filters-checkbox form-checkbox">
                                <input type="checkbox" id="availability-group-1" checked>
                                <label for="availability-group-1">
                                    <span>В наличии</span>
                                    <sup class="catalog__item-count">100</sup>
                                </label>
                            </div>
                            <div class="catalog__filters-checkbox form-checkbox">
                                <input type="checkbox" id="availability-group-2">
                                <label for="availability-group-2">
                                    <span>Под заказ</span>
                                    <sup class="catalog__item-count">100</sup>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion__item">
                    <button class="catalog__accordion-btn accordion__btn js-accordion-btn" aria-expanded="true">
                        <span class="accordion__title">Бренд</span>
                        <svg aria-hidden="true" class="orange">
                            <use xlink:href="{{ url('/images/sprite.svg#chevron-down') }}"></use>
                        </svg>
                    </button>
                    <div class="accordion__content">
                        <div class="catalog__filters-list">
                            @foreach(($manufacturers ?? []) as $manufacturer)
                                @php
                                    $cbId = 'brand-' . $manufacturer->id;
                                @endphp

                                <div class="catalog__filters-checkbox form-checkbox">
                                    <input type="checkbox"
                                           name="manufacturer_id"
                                           value="{{ $manufacturer->id }}"
                                           id="{{ $cbId }}">
                                    <label for="{{ $cbId }}">
                                        <span>{{ $manufacturer->title }}</span>
                                        <sup class="catalog__item-count">100</sup>
                                    </label>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>

            <button type="button" class="catalog__apply-btn btn btn--tertiary js-catalog-apply-btn">
                <span>Применить</span>
            </button>
        </div>

        <div class="catalog__content">
            <div class="catalog__controls">
                <div class="catalog__controls-line">
                    <button type="button" class="catalog__filters-btn btn btn--tertiary btn--sm js-catalog-filters-btn">
                        <svg aria-hidden="true">
                            <use xlink:href="{{ url('/images/sprite.svg#filters') }}"></use>
                        </svg>
                        <span>Фильтры</span>
                    </button>
                    <div class="catalog__chips">
                        <button type="button" class="catalog__chip btn btn--sm">
                            <span>В наличии</span>
                            <svg aria-hidden="true">
                                <use xlink:href="{{ url('/images/sprite.svg#close') }}"></use>
                            </svg>
                        </button>

                        <button type="button" class="catalog__chip btn btn--sm">
                            <span>Freescale</span>
                            <svg aria-hidden="true">
                                <use xlink:href="{{ url('/images/sprite.svg#close') }}"></use>
                            </svg>
                        </button>

                        <button type="button" class="catalog__chip btn btn--sm">
                            <span>NXP Semiconductors</span>
                            <svg aria-hidden="true">
                                <use xlink:href="{{ url('/images/sprite.svg#close') }}"></use>
                            </svg>
                        </button>
                    </div>
                </div>
                <button type="button" class="catalog__clear-btn btn btn--sm">
                    <svg aria-hidden="true">
                        <use xlink:href="{{ url('/images/sprite.svg#clear') }}"></use>
                    </svg>
                    <span>Сбросить все</span>
                </button>
            </div>

           @if(count($products) > 0)
                <ul class="catalog__list">
                    @foreach($products ?? [] as $item)
                        @php
                            $arr = $item?->parameters?->toArray() ?? [];
                            $chunkSize = max(1, (int)ceil(count($arr) / 2));
                            $res = $arr ? array_chunk($arr, $chunkSize) : [[], []];
                            $qtyId = 'product-count-' . $item->id;
                        @endphp
                        <li>
                            @php
                                $inCart = !empty($cartItems[$item->id]);
                                $cartQty = (int)($cartItems[$item->id]['qty'] ?? 1);
                            @endphp

                            <article class="product-card" data-catalog-product="{{ $item->id }}">
                                <div class="product-card__img">
                                    <picture>
                                        <img src="{{ $item->getThumbnailUrl() }}"
                                             title="{{ $item->image_title }}"
                                             alt="{{ $item->image_alt ?? $item->title }}">
                                    </picture>
                                </div>

                                <div class="product-card__info">
                                    <a href="{{ route('frontend.product', ['slug' => $item->slug]) }}" class="product-card__title">
                                        <h2>{{ $item->title }}</h2>
                                    </a>

                                    <div class="product-card__characteristics js-characteristics">
                                        <div class="product-card__characteristics-wrap js-characteristics-wrap">
                                            <dl class="product-card__list">
                                                <div class="product-card__list-row">
                                                    <dt class="product-card__list-title">Бренд:</dt>
                                                    <dd class="product-card__list-text">{{ $item?->manufacturer?->title }}</dd>
                                                </div>
                                                @foreach($res[0] ?? [] as $param)
                                                <div class="product-card__list-row">
                                                    <dt class="product-card__list-title">{{ $param['name'] }}:</dt>
                                                    <dd class="product-card__list-text">{{ $param['value'] }}</dd>
                                                </div>
                                                @endforeach
                                            </dl>
                                            <dl class="product-card__list">
                                                @foreach($res[1] ?? [] as $param)
                                                    <div class="product-card__list-row">
                                                        <dt class="product-card__list-title">{{ $param['name'] }}:</dt>
                                                        <dd class="product-card__list-text">{{ $param['value'] }}</dd>
                                                    </div>
                                                @endforeach
                                            </dl>
                                        </div>
                                    </div>
                                </div>

                                <div class="product-card__controls">
                                    <div class="product-card__count form-input-count">
                                        @if($item->status == 1)
                                            <label for="{{ $qtyId }}">Количество</label>
                                            <button type="button"
                                                    class="btn btn--secondary btn--icon"
                                                    data-qty-step="-1">
                                                <svg aria-hidden="true">
                                                    <use xlink:href="{{ url('/images/sprite.svg#minus') }}"></use>
                                                </svg>
                                                <span class="sr-only">Уменьшить количество</span>
                                            </button>
                                            <input type="number"
                                                   id="{{ $qtyId }}"
                                                   min="0"
                                                   value="{{ $inCart ? $cartQty : 1 }}"
                                                   data-catalog-qty>

                                            <button type="button"
                                                    class="btn btn--secondary btn--icon"
                                                    data-qty-step="1">
                                                <svg aria-hidden="true">
                                                    <use xlink:href="{{ url('/images/sprite.svg#plus') }}"></use>
                                                </svg>
                                                <span class="sr-only">Увеличить количество</span>
                                            </button>
                                        @else
                                            <label>Нет в наличии</label>
                                        @endif

                                    </div>

                                    @if($item->status == 1)
                                        <button type="button"
                                                class="product-card__add-btn btn btn--primary"
                                                data-catalog-add
                                                style="{{ $inCart ? 'display:none' : '' }}">
                                            <svg aria-hidden="true">
                                                <use xlink:href="{{ url('/images/sprite.svg#cart-add') }}"></use>
                                            </svg>
                                            <span>Добавить в корзину</span>
                                        </button>


                                        <a href="{{ route('frontend.cart.index') }}"
                                           class="product-card__add-btn btn btn--secondary"
                                           data-catalog-incart
                                           style="{{ $inCart ? '' : 'display:none' }}">
                                            <svg aria-hidden="true">
                                                <use xlink:href="{{ url('/images/sprite.svg#cart') }}"></use>
                                            </svg>
                                            <span>В корзине</span>
                                        </a>

                                        <p class="product-card__price-text">
                                            @if($item->price > 0)
                                                {{ $item->price }}
                                            @else
                                                Цену уточняйте у&nbsp;менеджера
                                            @endif
                                        </p>
                                    @endif

                                </div>
                            </article>
                        </li>
                    @endforeach
                </ul>

                {{ $products->links('layouts.frontend_pagination') }}
            @else
                <p style="text-align: center;">Каталог пуст</p>
           @endif

        </div>
    </div>

    <section class="request-banner container-lg">
        <div class="request-banner__wrap">
            <div class="request-banner__title section-title white">
                <h2>Нужен компонент,<br>которого нет в&nbsp;каталоге?</h2>
            </div>
            <p class="request-banner__description">Просто отправьте запрос — и мы найдём то, что&nbsp;вы&nbsp;ищете</p>
            <a href="{{ route('frontend.nomenclature_request.index') }}" class="request-banner__link btn btn--primary btn--lg">
                <span>Отправить запрос</span>
                <svg aria-hidden="true" class="white">
                    <use xlink:href="{{ url('/images/sprite.svg#arrow-right') }}"></use>
                </svg>
            </a>
        </div>
    </section>

    @include('layouts._watched_cards')

@endsection

@section('js')

@endsection
