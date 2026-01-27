@extends('layouts.frontend')

@section('title', 'Корзина')

@section('content')
    <main>
        <div class="page-header container-lg">
            <div class="page-header__wrap">
                <ul class="breadcrumbs">
                    <li><a href="{{ url('/') }}" class="breadcrumbs-item">Главная</a></li>
                    <li><span class="breadcrumbs-item">Корзина</span></li>
                </ul>
                <h1>Корзина</h1>
            </div>
        </div>

        <div class="cart container-sm" data-cart-page>
            <div class="cart__content">
                <div class="cart__all-checkbox form-checkbox">
                    <input type="checkbox" id="cart-all-add" data-cart-select-all>
                    <label for="cart-all-add">Добавить в заказ все</label>
                </div>

                <ul class="cart__list">
                    @forelse($cartRows as $item)
                        @php
                            $product = $item['product'] ?? null;
                            $qty = (int)($item['qty'] ?? 1);
                            $checked = (bool)($item['selected'] ?? ($item['checked'] ?? true));
                            $pendingUntil = $item['pending_remove_until'] ?? null;

                            $id = $product?->id ?? ($item['product_id'] ?? 0);
                            $title = $product?->title ?? ($item['title'] ?? 'Товар');
                            $slug = $product?->slug ?? null;
                        @endphp

                        <li data-cart-item
                            data-product-id="{{ $id }}"
                            @if($pendingUntil) data-pending-until="{{ $pendingUntil }}" @endif
                        >
                            <article class="cart-item">
                                <div class="cart__item-checkbox form-checkbox">
                                    <input type="checkbox"
                                           id="cart-add-product-{{ $id }}"
                                           class="js-cart-item-check"
                                           data-cart-select
                                            {{ $checked ? 'checked' : '' }}>
                                    <label for="cart-add-product-{{ $id }}" class="sr-only">Добавить в заказ</label>
                                </div>

                                <div>
                                    <div class="cart__item-img">
                                        <img src="{{ $product?->getThumbnailUrl() }}"
                                             alt="{{ $product?->image_alt ?? $product?->title }}"
                                             loading="lazy">
                                    </div>
                                </div>

                                <div class="cart__item-info">
                                    @if($slug)
                                        <a href="{{ route('frontend.product', ['slug' => $slug]) }}" class="cart__item-title">
                                            <h2>{{ $title }}</h2>
                                        </a>
                                    @else
                                        <div class="cart__item-title">
                                            <h2>{{ $title }}</h2>
                                        </div>
                                    @endif

                                    <div class="cart__controls">
                                        <div class="cart__count-input form-input-count">
                                            <label for="cart-count-product-{{ $id }}">Количество</label>

                                            <button type="button"
                                                    class="btn btn--secondary btn--icon js-cart-qty-minus"
                                                    data-cart-step="-1">
                                                <svg aria-hidden="true">
                                                    <use xlink:href="{{ asset('/images/sprite.svg#minus') }}"></use>
                                                </svg>
                                                <span class="sr-only">Уменьшить количество</span>
                                            </button>

                                            <input type="number"
                                                   id="cart-count-product-{{ $id }}"
                                                   class="js-cart-qty-input"
                                                   data-cart-qty
                                                   min="1"
                                                   value="{{ $qty }}"
                                                   @if($pendingUntil) disabled @endif
                                            >

                                            <button type="button"
                                                    class="btn btn--secondary btn--icon js-cart-qty-plus"
                                                    data-cart-step="1">
                                                <svg aria-hidden="true">
                                                    <use xlink:href="{{ asset('/images/sprite.svg#plus') }}"></use>
                                                </svg>
                                                <span class="sr-only">Увеличить количество</span>
                                            </button>
                                        </div>

                                        <button type="button"
                                                class="btn btn--secondary js-cart-remove"
                                                data-cart-remove
                                                @if($pendingUntil) disabled @endif
                                        >
                                            <svg aria-hidden="true">
                                                <use xlink:href="{{ asset('/images/sprite.svg#delete') }}"></use>
                                            </svg>
                                            <span>Удалить</span>
                                        </button>

                                        {{-- если используешь pending remove UI --}}
                                        <div data-cart-pending style="{{ $pendingUntil ? '' : 'display:none' }}">
                                            Удаление через <span data-cart-countdown>5</span> сек.
                                            <button type="button" class="btn btn--link" data-cart-undo>
                                                Отменить
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </li>
                    @empty
                        <li>
                            <div class="cart__empty-title">
                                <h2>На текущий момент ваша&nbsp;корзина&nbsp;пуста</h2>
                            </div>
                        </li>
                    @endforelse
                </ul>
            </div>

            <div class="cart__total">
                <div class="cart__total-title">
                    <h2>Товаров в заказе: <span data-cart-selected-count>{{ $selectedCount ?? 0 }}</span></h2>
                </div>

                <div class="cart__total-btns">
                    <button type="button" class="btn btn--secondary btn--lg" disabled>
                        <svg aria-hidden="true">
                            <use xlink:href="{{ asset('/mages/sprite.svg#print') }}"></use>
                        </svg>
                        <span>Распечатать заказ</span>
                    </button>

                    <button type="button"
                            class="btn btn--primary btn--lg js-cart-checkout"
                            data-cart-checkout>
                        <svg aria-hidden="true">
                            <use xlink:href="{{ asset('/images/sprite.svg#orders') }}"></use>
                        </svg>
                        <span>Оформить заказ</span>
                    </button>
                </div>
            </div>
        </div>
    </main>
@endsection
