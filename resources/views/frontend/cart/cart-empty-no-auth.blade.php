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

        <div class="cart container-sm">
            <div class="cart__content is-empty">
                <div class="cart__empty-title">
                    <h2>На текущий момент ваша&nbsp;корзина&nbsp;пуста</h2>
                </div>

                <a href="{{ route('frontend.catalog') }}" class="btn btn--primary btn--lg">
                    <span>Начать покупки</span>
                    <svg aria-hidden="true">
                        <use xlink:href="{{ asset('/images/sprite.svg#arrow-right') }}"></use>
                    </svg>
                </a>
            </div>

            <div class="cart__total">
                <div class="cart__total-title">
                    <h2>Товаров в заказе: 0</h2>
                </div>

                <div class="cart__total-btns">
                    <button type="button" class="btn btn--secondary btn--lg" disabled>
                        <svg aria-hidden="true">
                            <use xlink:href="{{ asset('/images/sprite.svg#print') }}"></use>
                        </svg>
                        <span>Распечатать заказ</span>
                    </button>

                    <p class="cart__total-description">
                        Чтобы оформить заказ, авторизуйтесь в&nbsp;личном кабинете и/или&nbsp;заполните информацию о компании на вкладке Профиль
                    </p>

                    <button type="button" class="btn btn--tertiary btn--lg" data-modal-trigger="login">
                        <svg aria-hidden="true">
                            <use xlink:href="{{ asset('/images/sprite.svg#user') }}"></use>
                        </svg>
                        <span>В личный кабинет</span>
                    </button>
                </div>
            </div>
        </div>
    </main>
@endsection
