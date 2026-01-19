@extends('layouts.frontend')

@section('title', $title)

@section('description', $meta_description)

@section('keywords', $meta_keywords)

@section('seo_url_canonical', $seo_url_canonical)

@section('css')

@endsection

@section('content')

    @include('layouts._breadcrumbs')

    @php
        $arr = $product->parameters?->toArray() ?? [];
        $inCart = !empty($cartItems[$product->id]);
        $cartQty = (int)($cartItems[$product->id]['qty'] ?? 1);
    @endphp

    <div class="product-hero container-lg" data-product-page data-product-id="{{ $product->id }}">
        <div class="product-hero__wrap">
            <div class="product-hero__container">

                <div class="product-hero__content">
                    <div class="product-hero__left">
                        <div class="product-hero__title">
                            <h1>{{ $product->title }}</h1>
                        </div>
                        <div class="product-hero__img-wrap">
                            <div class="product-hero__img">
                                <picture>
                                    <img src="{{ $product->getOriginUrl() }}"
                                         alt="{{ $product->image_alt ?? $product->title }}"
                                         title="{{ $product->image_title }}">
                                </picture>
                            </div>
                            <p class="product-hero__img-text">
                                Изображения служат только для ознакомления, см.&nbsp;техническую документацию
                            </p>
                        </div>
                    </div>

                    <div class="product-hero__right">
                        <div class="product-hero__title">
                            <h1>{{ $product->manufacturer->title }}</h1>
                        </div>

                        <div class="product-hero__info">
                            <div class="product-hero__info-left">
                                <div class="product-hero__characteristics">
                                    <dl class="product-hero__list">
                                        @if($product->parameters)
                                            @foreach(array_slice($arr, 0, 5) as $parameter)
                                                <div class="product-hero__list-row">
                                                    <dt class="product-hero__list-title">{{ $parameter['name'] }}:</dt>
                                                    <dd class="product-hero__list-text">{{ $parameter['value'] }}</dd>
                                                </div>
                                            @endforeach
                                        @endif
                                    </dl>
                                    <a href="#product-characteristics" class="btn btn--secondary js-anchor-link">
                                        <span>Все характеристики</span>
                                        <svg aria-hidden="true">
                                            <use xlink:href="{{ url('/images/sprite.svg#chevron-down') }}"></use>
                                        </svg>
                                    </a>
                                </div>

                                <dl class="product-hero__numbs">
                                    <div class="product-hero__numbs-row">
                                        <dt class="product-hero__list-title">Номенклатурный номер:</dt>
                                        <dd class="product-hero__list-text">
                                            <span>{{ $product->n_number }}</span>
                                            <button type="button" class="product-hero__copy-btn btn btn--icon btn--sm">
                                                <span class="sr-only">Копировать</span>
                                                <svg aria-hidden="true">
                                                    <use xlink:href="{{ url('/images/sprite.svg#file-copy') }}"></use>
                                                </svg>
                                            </button>
                                        </dd>
                                    </div>

                                    <div class="product-hero__numbs-row">
                                        <dt class="product-hero__list-title">Артикул:</dt>
                                        <dd class="product-hero__list-text">
                                            <span>{{ $product->article }}</span>
                                            <button type="button" class="product-hero__copy-btn btn btn--icon btn--sm">
                                                <span class="sr-only">Копировать</span>
                                                <svg aria-hidden="true">
                                                    <use xlink:href="{{ url('/images/sprite.svg#file-copy') }}"></use>
                                                </svg>
                                            </button>
                                        </dd>
                                    </div>
                                </dl>
                            </div>

                            <div class="product-hero__info-right">
                                <div class="product-hero__info-count form-input-count">
                                    <label for="product-count">Количество</label>

                                    <button type="button"
                                            class="btn btn--secondary btn--icon"
                                            data-qty-step="-1">
                                        <svg aria-hidden="true">
                                            <use xlink:href="{{ url('/images/sprite.svg#minus') }}"></use>
                                        </svg>
                                        <span class="sr-only">Уменьшить количество</span>
                                    </button>

                                    <input type="number"
                                           id="product-count"
                                           min="0"
                                           value="{{ $inCart ? $cartQty : 1 }}"
                                           data-product-qty>

                                    <button type="button"
                                            class="btn btn--secondary btn--icon"
                                            data-qty-step="1">
                                        <svg aria-hidden="true">
                                            <use xlink:href="{{ url('/images/sprite.svg#plus') }}"></use>
                                        </svg>
                                        <span class="sr-only">Увеличить количество</span>
                                    </button>
                                </div>

                                <button type="button"
                                        class="product-hero__info-add-btn btn btn--primary"
                                        data-product-add
                                        style="{{ $inCart ? 'display:none' : '' }}">
                                    <svg aria-hidden="true">
                                        <use xlink:href="{{ url('/images/sprite.svg#cart-add') }}"></use>
                                    </svg>
                                    <span>Добавить в корзину</span>
                                </button>

                                <a href="{{ route('frontend.cart.index') }}"
                                   class="product-hero__info-add-btn btn btn--secondary"
                                   data-product-incart
                                   style="{{ $inCart ? '' : 'display:none' }}">
                                    <svg aria-hidden="true">
                                        <use xlink:href="{{ url('/images/sprite.svg#cart') }}"></use>
                                    </svg>
                                    <span>В корзине</span>
                                </a>

                                <p class="product-hero__info-text">
                                    @if($product->price > 0)
                                        {{ $product->price }}
                                    @else
                                        Цену уточняйте у менеджера
                                    @endif
                                </p>

                                <a href="{{ route('frontend.conditions') }}" class="product-hero__info-link btn btn--link">
                                    <span>Доставка и оплата</span>
                                    <svg aria-hidden="true">
                                        <use xlink:href="{{ url('/images/sprite.svg#chevron-right') }}"></use>
                                    </svg>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="product-desc container-sm">
        <section>
            <div class="product-desc__title">
                <h2>Описание</h2>
            </div>
            <p class="product-desc__description">{{ $product->description }}</p>
        </section>

        <section>
            <div class="product-desc__title">
                <h2>Техническая документация</h2>
            </div>
            <div class="product-desc__btns">
                @foreach($product->documents ?? [] as $document)
                    <a href="{{ $document->getDocument() }}" download="{{ $document->file }}"
                       class="product-desc__btn btn">
                        <svg aria-hidden="true">
                            <use xlink:href="{{ url('/images/sprite.svg#download') }}"></use>
                        </svg>
                        <span class="product-desc__btn-info">
                            <span class="product-desc__btn-title">{{ $document->name }}</span>
                            <span class="product-desc__btn-type">{{ $document->getDocumentInfo() }}</span>
                        </span>
                    </a>
                @endforeach
            </div>
        </section>

        <section id="product-characteristics" class="product-desc__characteristics">
            <div class="product-desc__title">
                <h2>Технические характеристики</h2>
            </div>
            <div class="product-desc__tables">
                @php
                    $arr = $product->parameters ? $product->parameters->toArray() : [];
                    $chunkSize = max(1, (int)ceil(count($arr) / 2));
                    $res = $arr ? array_chunk($arr, $chunkSize) : [[], []];
                @endphp

                @if(!empty($arr))
                    <dl class="product-desc__table">
                        @foreach($res[0] ?? [] as $item)
                            <div class="product-desc__table-row">
                                <dt class="product-desc__row-title">{{ $item['name'] }}</dt>
                                <dd class="product-desc__row-text">{{ $item['value'] }}</dd>
                            </div>
                        @endforeach
                    </dl>

                    <dl class="product-desc__table">
                        @foreach($res[1] ?? [] as $item)
                            <div class="product-desc__table-row">
                                <dt class="product-desc__row-title">{{ $item['name'] }}</dt>
                                <dd class="product-desc__row-text">{{ $item['value'] }}</dd>
                            </div>
                        @endforeach
                    </dl>
                @else
                    <p class="product-desc__description">Характеристики не указаны.</p>
                @endif
            </div>
        </section>
    </div>

    @include('layouts._watched_cards')

@endsection

@section('js')

@endsection
