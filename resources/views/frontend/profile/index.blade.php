@extends('layouts.frontend')

@section('title', $title)

@section('description', $meta_description)

@section('keywords', $meta_keywords)

@section('seo_url_canonical', $seo_url_canonical)

@section('css')

    {!! Html::style('/css/profile.css?v=2') !!}

@endsection

@section('content')

    <div class="page-header container-lg">
        <div class="page-header__wrap">
            @include('layouts._breadcrumbs')
            <h1>Личный кабинет</h1>

        </div>
    </div>

    <div class="account container-md">
        <ul class="account__tabs tabs">
            <li class="tab">
                <input type="radio" name="account" id="account-profile" class="js-tab" checked="">
                <label for="account-profile">
                    <svg aria-hidden="true">
                        <use xlink:href="{{ url('/images/sprite.svg#profile') }}"></use>
                    </svg>
                    Профиль
                </label>
            </li>
            <li class="tab">
                <input type="radio" name="account" id="account-orders" class="js-tab">
                <label for="account-orders">
                    <svg aria-hidden="true">
                        <use xlink:href="{{ url('/images/sprite.svg#orders') }}"></use>
                    </svg>
                    Мои заказы
                </label>
            </li>
            <li class="tab">
                <input type="radio" name="account" id="account-requests" class="js-tab">
                <label for="account-requests">
                    <svg aria-hidden="true">
                        <use xlink:href="{{ url('/images/sprite.svg#requests') }}"></use>
                    </svg>
                    Мои запросы
                </label>
            </li>
            <li class="tab">
                <input type="radio" name="account" id="account-claims" class="js-tab js-tab-with-tooltips">
                <label for="account-claims">
                    <svg aria-hidden="true">
                        <use xlink:href="{{ url('/images/sprite.svg#claims') }}"></use>
                    </svg>
                    Претензии
                </label>
            </li>
            <li class="tab">
                <a href="{{ route('frontend.profile.logout') }}" class="tab__btn btn">
                    <svg aria-hidden="true">
                        <use xlink:href="{{ url('/images/sprite.svg#logout') }}"></use>
                    </svg>
                    <span>Выйти</span>
                </a>
            </li>
        </ul>
        <div class="account__tabs-content tabs-content">

            @php
                $lastIp = Auth::guard('customer')->user()?->lastSuccessfulLoginIp();
                $lastLoginAt = Auth::guard('customer')->user()?->lastSuccessfulLoginAt();
                $location = StringHelper::getLocation($lastIp);
                $place = isset($location['country']) && isset($location['city']) ? ' ' . $location['country'] . ', ' . $location['city']:'';
            @endphp

            <p style="padding-bottom: 16px">Последний вход: {{ date('d.m.Y H:i:s', strtotime($lastLoginAt)) }}&nbsp;&nbsp;&nbsp;IP: {{ $lastIp }}{{ $place }} </p>

            @include('frontend.profile.tabs.account-profile')

            @include('frontend.profile.tabs.orders')

            @include('frontend.profile.tabs.requests')

            <div data-tab="account-claims" class="claims">
                <section class="account__container">
                    <div class="account__section-header">
                        <div class="account__section-title">
                            <h2>Претензии</h2>
                        </div>
                        <button type="button" class="btn btn--tertiary btn--sm" data-modal-trigger="create-claim">
                            <svg aria-hidden="true">
                                <use xlink:href="{{ url('/images/sprite.svg#plus') }}"></use>
                            </svg>
                            <span>Создать</span>
                        </button>
                    </div>
                    <div class="account__table">
                        <div class="account__table-wrap">
                            <table>
                                <thead>
                                <tr>
                                    <th>Тип претензии</th>
                                    <th>По счету</th>
                                    <th>Позиция</th>
                                    <th>Количество<br>в счете</th>
                                    <th>Количество<br>с браком</th>
                                    <th>Статус претензии</th>
                                    <th>Результат<br>рассмотрения</th>
                                    <th>Бланк</th>
                                    <th>Фото</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($complaints ?? [] as $complaint)
                                    <tr class="account__item js-account-item" data-list="claims">
                                        <td>{{ $complaintTypes[$complaint->type] ?? '—' }}</td>
                                        <td>№{{ $complaint->order_id }} от {{ $complaint->order?->created_at?->format('d.m.Y') }}</td>
                                        <td>
                                            <div class="account__table-product tooltip js-account-tooltip">
                                                <div class="tooltip__body js-account-tooltip-tbody" role="tooltip">
                                                    <span>{{ $complaint->product?->title ?? '—' }}</span>
                                                </div>
                                                <span class="account__table-title js-account-tooltip-title">{{ $complaint->product?->title ?? '—' }}</span>
                                            </div>
                                        </td>
                                        <td class="text-medium text-nowrap text-right">{{ number_format((int) $complaint->order_count, 0, '', ' ') }}</td>
                                        <td class="account__table-defect-count">{{ number_format((int) $complaint->return_count, 0, '', ' ') }}</td>
                                        <td>
                                            <div class="account__table-status {{ $complaint->getStatus()?->cssClass() ?? 'in-progress' }}">
                                                <svg aria-hidden="true">
                                                    <use xlink:href="{{ url('/images/sprite.svg#' . $complaint->getStatus()?->statusIcon() ?? 'cogwheel') }}"></use>
                                                </svg>
                                                <span>{{ $complaint->getStatus()?->label() ?? 'В обработке' }}</span>
                                            </div>
                                        </td>
                                        <td class="account__table-result"></td>
                                        <td class="text-center">—</td>
                                        <td class="text-center">—</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">Претензий пока нет</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <button type="button" class="account__more-btn btn btn--secondary js-account-load-more" data-list="claims" data-step="10">
                        <span>Показать еще</span>
                    </button>
                </section>
            </div>
        </div>
    </div>

    <div class="modal js-modal" data-modal-name="general-info">
        <div class="modal__wrap">
            <div class="modal__dialog js-modal-dialog" role="dialog" aria-modal="true">
                <button type="button" class="modal__close-btn btn btn--icon btn--sm js-modal-close">
                    <span class="sr-only">Закрыть модальное окно</span>
                    <svg aria-hidden="true">
                        <use xlink:href="{{ url('/images/sprite.svg#clos') }}e"></use>
                    </svg>
                </button>
                <div class="modal__content">
                    <div class="modal__title">
                        <h2>Изменить общую информацию</h2>
                    </div>

                    <form class="modal__form is-success" id="general-info-form">
                        <p>*-обязательные поля</p>
                        <div class="form-input">
                            <label for="general-info-name">Ваше имя*</label>
                            <input type="text" name="name" id="general-info-name" placeholder='Иван Иванов'
                                   value="{{  Auth::guard('customer')->user()->name }}">
                        </div>
                        <div class="form-input">
                            <label for="general-info-email">Электронная почта*</label>
                            <input type="text" name="email" id="general-info-email" placeholder='user@example.ru'
                                   value="{{  Auth::guard('customer')->user()->email }}">
                        </div>
                        <div class="form-input">
                            <label for="general-info-phone">Номер телефона*</label>
                            <input type="tel" id="general-info-phone"
                                   placeholder='+7 900 000-00-00'
                                   required
                                   oninput="this.value = this.value.replace(/[^0-9+\-\s]/g, '')"
                                   name="phone"
                                   value="{{ Auth::guard('customer')->user()->phone }}">
                        </div>
                        <div class="form-password">
                            <label for="general-info-password">Пароль</label>
                            <input type="password" name="password" id="general-info-password" placeholder='*******'>
                            <div class="form-display-btn">
                                <input type="checkbox" id="general-info-display-password">
                                <label for="general-info-display-password">Показать пароль</label>
                            </div>
                        </div>
                        <div class="form-password">
                            <label for="general-info-repeat-password">Повторите пароль</label>
                            <input type="password" name="password_confirmation" id="general-info-repeat-password"
                                   placeholder='*******'>
                            <div class="form-display-btn">
                                <input type="checkbox" id="general-info-display-repeat-password">
                                <label for="general-info-display-repeat-password">Показать пароль</label>
                            </div>
                        </div>
                        <div class="modal__btns">
                            <button type="submit" class="btn btn--primary">
                                <svg aria-hidden="true">
                                    <use xlink:href="{{ url('/images/sprite.svg#save') }}"></use>
                                </svg>
                                <span>Сохранить</span>
                            </button>
                        </div>
                        <div class="result">
                            <div class="loading-message"
                                 style="display:none; align-items:center; gap:8px;">
                                Загрузка...
                            </div>
                            <span class="success-message " hidden>
                                Данные успешно сохранены! Перезагрузка страницы...
                            </span>
                            <div class="message-error result" id="general-info-errors"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal js-modal" data-modal-name="company-info">
        <div class="modal__wrap">
            <div class="modal__dialog js-modal-dialog" role="dialog" aria-modal="true">
                <button type="button" class="modal__close-btn btn btn--icon btn--sm js-modal-close">
                    <span class="sr-only">Закрыть модальное окно</span>
                    <svg aria-hidden="true">
                        <use xlink:href="{{ url('/images/sprite.svg#close') }}"></use>
                    </svg>
                </button>
                <div class="modal__content">
                    <div class="modal__title">
                        <h2>Изменить информацию о&nbsp;компании</h2>
                    </div>
                    <p>*-обязательные поля</p>
                    <form class="modal__form is-success" id="company-info-form">
                        <div class="form-input">
                            <label for="company-info-company-name">Название компании*</label>
                            <input type="text" id="company-info-company-name" name="name"
                                   placeholder='ООО “ЭлектроМонтаж”'
                                   value="{{ Auth::guard('customer')->user()->company?->name }}" required>
                        </div>
                        <div class="form-input">
                            <label for="company-info-inn">ИНН*</label>
                            <input type="number" id="company-info-inn"
                                   name="inn"
                                   placeholder='1122312321428234'
                                   value="{{ Auth::guard('customer')->user()->company?->inn }}" required>
                        </div>
                        <div class="form-input">
                            <label for="company-info-name">Контактное лицо*</label>
                            <input type="text"
                                   name="contact_person"
                                   id="company-info-name" placeholder='Петр Петров'
                                   value="{{ Auth::guard('customer')->user()->company?->contact_person }}" required>
                        </div>
                        <div class="form-input">
                            <label for="company-info-phone">Номер телефона*</label>
                            <input type="tel"
                                   name="phone"
                                   id="company-info-phone"
                                   placeholder='+7 900 000-00-00'
                                   oninput="this.value = this.value.replace(/[^0-9+\-\s]/g, '')"

                                   value="{{ Auth::guard('customer')->user()->company?->phone }}" required>
                        </div>
                        <div class="form-input">
                            <label for="company-info-email">Электронная почта*</label>
                            <input type="email"
                                   name="email"
                                   id="company-info-email" placeholder='customer@gmail.com'
                                   value="{{ Auth::guard('customer')->user()->company?->email }}" required>
                        </div>
                        <div class="modal__btns">
                            <button type="submit" class="btn btn--primary">
                                <svg aria-hidden="true">
                                    <use xlink:href="{{ url('/images/sprite.svg#save') }}"></use>
                                </svg>
                                <span>Сохранить</span>
                            </button>
                        </div>
                        <div class="result">
                            <div class="loading-message"
                                 style="display:none; align-items:center; gap:8px;">
                                Загрузка...
                            </div>
                            <span class="success-message" hidden>
                                 Данные успешно сохранены! Перезагрузка страницы...
                            </span>
                            <div class="message-error result" id="company-info-errors"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal--create-claim js-modal" data-modal-name="create-claim">
        <div class="modal__wrap">
            <div class="modal__dialog js-modal-dialog" role="dialog" aria-modal="true">
                <button type="button" class="modal__close-btn btn btn--icon btn--sm js-modal-close">
                    <span class="sr-only">Закрыть модальное окно</span>
                    <svg aria-hidden="true">
                        <use xlink:href="{{ url('/images/sprite.svg#close') }}"></use>
                    </svg>
                </button>
                <div class="modal__content">
                    <div class="modal__title">
                        <h2>Создать претензию</h2>
                    </div>

                    {!! Form::open(['url' => route('frontend.profile.complaints.store'), 'files' => true, 'method' => 'post', 'class' => 'modal__form is-success']) !!}

                    <div class="form-input__line">
                        <div class="form-select">

                            {!! Form::label('create-claim-type', 'Тип претензии') !!}

                            <select name="type" id="create-claim-type" class="js-select" required>
                                @foreach($complaintTypes ?? [] as $typeId => $typeName)
                                    <option value="{{ $typeId }}">{{ $typeName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-select">

                            {!! Form::label('create-claim-invoice-numb', 'Номер счета') !!}

                            <select name="order_id" id="create-claim-invoice-numb" class="js-select"
                                    @if(($orders ?? collect())->isNotEmpty()) required @else disabled @endif>
                                @forelse($orders ?? [] as $order)
                                    <option value="{{ $order->id }}">№{{ $order->id }}
                                        от {{ $order->created_at?->format('d.m.Y') }}</option>
                                @empty
                                    <option value="" disabled selected>Нет доступных счетов</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="form-select">

                        {!! Form::label('create-claim-product', 'Наименование позиции') !!}

                        <select name="product_id" id="create-claim-product" class="js-select"
                                @if(($complaintProducts ?? collect())->isNotEmpty()) required @else disabled @endif>
                            @forelse($complaintProducts ?? [] as $orderProduct)
                                <option value="{{ $orderProduct->product_id }}"
                                        data-order-id="{{ $orderProduct->order_id }}"
                                        data-order-count="{{ $orderProduct->count }}">
                                    {{ $orderProduct->product?->title ?? $orderProduct->product_info }}
                                </option>
                            @empty
                                <option value="" disabled selected>Нет доступных позиций</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="form-input__line">
                        <div class="form-input">

                            {!! Form::label('create-claim-count-invoice', 'Количество в счете') !!}

                            <input type="number" id="create-claim-count-invoice" readonly>
                        </div>
                        <div class="form-input">

                            {!! Form::label('create-claim-count-defect', 'Количество с браком') !!}

                            {!! Form::number('return_count', old('return_count'), ['placeholder' => "1", 'min' => "1", 'id' => "create-claim-count-defect", 'class' => 'form-control', 'required']) !!}

                        </div>
                    </div>
                    <div class="form-input__btns-line">
                        <div class="form-input-file js-input-file">
                            <label for="create-claim-form" class="btn btn--secondary">
                                <svg aria-hidden="true">
                                    <use xlink:href="{{ url('/images/sprite.svg#file-download') }}"></use>
                                </svg>
                                <span>Загрузить претензию на официальном бланке</span>
                            </label>

                            {!! Form::file('claim_form',  ['class' => 'sr-only', 'id' => 'create-claim-form']) !!}

                        </div>
                        <div class="form-input-file js-input-file">
                            <label for="create-claim-image" class="btn btn--secondary">
                                <svg aria-hidden="true">
                                    <use xlink:href="{{ url('/images/sprite.svg#image-add') }}"></use>
                                </svg>
                                <span>Загрузить фото</span>
                            </label>

                            {!! Form::file('claim_photo',  ['class' => 'sr-only', 'id' => 'create-claim-image']) !!}

                        </div>
                    </div>
                    <div class="modal__btns">
                        <button type="submit" class="btn btn--primary">
                            <svg aria-hidden="true">
                                <use xlink:href="{{ url('/images/sprite.svg#save') }}"></use>
                            </svg>
                            <span>Сохранить</span>
                        </button>
                    </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')

    {!! Html::script('/scripts/profile.js?v=4') !!}

@endsection
