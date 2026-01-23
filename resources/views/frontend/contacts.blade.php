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

    <div class="contacts container-sm">
        <div class="contacts__content">
            <div class="contacts__info">
                <div class="contacts__info-row">
                    <div class="contacts__info-title">
                        <svg aria-hidden="true" class="orange">
                            <use xlink:href="{{ url('/images/sprite.svg#phone') }}"></use>
                        </svg>
                        <span>Телефон</span>
                    </div>
                    <div class="contacts__info-text phone">
                        <a href="tel:{{ StringHelper::getPhoneTag(SettingsHelper::getInstance()->getValueForKey('PHONE')) }}">{{ SettingsHelper::getInstance()->getValueForKey('PHONE') }}</a>
                        <a href="tel:{{ StringHelper::getPhoneTag(SettingsHelper::getInstance()->getValueForKey('PHONE2')) }}">{{ SettingsHelper::getInstance()->getValueForKey('PHONE2') }}</a>
                    </div>
                </div>
                <div class="contacts__info-row">
                    <div class="contacts__info-title">
                        <svg aria-hidden="true" class="orange">
                            <use xlink:href="{{ url('/images/sprite.svg#mail') }}"></use>
                        </svg>
                        <span>Электронная почта</span>
                    </div>
                    <div class="contacts__info-text grid">
                        <a href="mailto:{{ SettingsHelper::getInstance()->getValueForKey('EMAIL') }}">{{ SettingsHelper::getInstance()->getValueForKey('EMAIL') }}</a>
                        <span>По общим вопросам</span>
                        <a href="mailto:{{ SettingsHelper::getInstance()->getValueForKey('SALE_EMAIL') }}">{{ SettingsHelper::getInstance()->getValueForKey('SALE_EMAIL') }}</a>
                        <span>По вопросам заказов</span>
                    </div>
                </div>
                <div class="contacts__info-row">
                    <div class="contacts__info-title">
                        <svg aria-hidden="true" class="orange">
                            <use xlink:href="{{ url('/images/sprite.svg#location') }}"></use>
                        </svg>
                        <span>Адрес</span>
                    </div>
                    <div class="contacts__info-text">
                        <a href="https://yandex.ru/maps/-/ccukboqbxa" target="_blank" rel="noopener noreferrer">Москва, проезд Южнопортовый 2-й, д.20А</a>
                    </div>
                </div>
                <div class="contacts__info-row">
                    <div class="contacts__info-title">
                        <svg aria-hidden="true" class="orange">
                            <use xlink:href="{{ url('/images/sprite.svg#time') }}"></use>
                        </svg>
                        <span>Время работы <br>отдела продаж и склада</span>
                    </div>
                    <div class="contacts__info-text grid">
                        <span>Понедельник - Четверг</span>
                        <span>с 8-30 до 17-30</span>
                        <span>Пятница</span>
                        <span>с 8-30 до 16-30</span>
                        <span>Суббота, Воскресенье</span>
                        <span>выходные</span>
                    </div>
                </div>
            </div>
            <div class="contacts__map" id="yandex-map"></div>
        </div>
        <div class="contacts__form-wrap">
            <div class="contacts__form-title">
                <h2>Есть вопросы? Задайте их нашим специалистам через чат на сайте или&nbsp;форму обратной связи</h2>
            </div>

            @php $user = Auth::guard('customer')->user() ?? null; @endphp

            {!! Form::open(['url' => route('frontend.contacts.send'), 'method' => 'post', 'class' => 'contacts__form is-success']) !!}
            <div class="form-input">
                {!! Form::label('name', 'Ваше имя*') !!}
                {!! Form::text('name', old('name', $user->name ?? null), ['id' => 'contacts-user-name', 'placeholder' => 'Иванов Иван', 'required']) !!}
                @if ($errors->has('name'))
                    <p class="text-danger">{{ $errors->first('name') }}</p>
                @endif
            </div>
            <div class="form-input">
                {!! Form::label('email', 'Электронная почта*') !!}
                {!! Form::email('email', old('email', $user->email ?? null), ['id' => 'contacts-email', 'placeholder' => 'customer@gmail.com', 'required']) !!}
                @if ($errors->has('email'))
                    <p class="text-danger">{{ $errors->first('email') }}</p>
                @endif
            </div>
            <div class="form-input">
                {!! Form::label('phone', 'Номер телефона*') !!}
                {!! Form::tel('phone', old('phone', $user->phone ?? null), ['id' => 'contacts-phone', 'placeholder' => '+7 900 000-00-00', 'required']) !!}
                @if ($errors->has('phone'))
                    <p class="text-danger">{{ $errors->first('phone') }}</p>
                @endif
            </div>
            <div class="contacts__textarea form-input">
                {!! Form::label('message', 'Текст сообщения*') !!}
                {!! Form::textarea('message', old('message'), ['id' => "contacts-message", 'placeholder' => 'Текст комментария', 'required']) !!}
                @if ($errors->has('message'))
                    <p class="text-danger">{{ $errors->first('message') }}</p>
                @endif
            </div>
            <div class="form-checkbox">
                <input type="checkbox" name="agreement" id="contacts-agreement">
                <label for="contacts-agreement">Я даю согласие на обработку персональных данных в&nbsp;соответствии с&nbsp;<a
                            href="{{ route('frontend.page', ['slug' => 'privacy-policy']) }}">Политикой
                        конфиденциальности</a></label>
                @if ($errors->has('agreement'))
                    <p class="text-danger">{{ $errors->first('agreement') }}</p>
                @endif
            </div>
            <div class="contacts__btn">
                <button type="submit" class="btn btn--primary">
                    <svg aria-hidden="true">
                        <use xlink:href="{{ url('/images/sprite.svg#mail') }}"></use>
                    </svg>
                    <span>Отправить</span>
                </button>
                @if (session('success'))
                    <span class="success-message">
                            <svg aria-hidden="true">
                                <use xlink:href="{{ url('/images/sprite.svg#check-circle') }}"></use>
                            </svg>
                            <span>Ваше сообщение успешно отправлено. В ближайшее время с Вами свяжется наш менеджер.</span>
                    </span>
                @endif

                @if (session('error'))
                    <span class="message-error">
                        <span>{{ session('error') }}</span>
                </span>
                @endif
            </div>

            {!! Form::close() !!}

        </div>
    </div>

@endsection

@section('js')

@endsection

