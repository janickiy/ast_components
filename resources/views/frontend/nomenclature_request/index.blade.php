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

    <div class="request container-xs">
        <p class="request__description">Не нашли необходимую позицию в&nbsp;каталоге?<br>Отправьте запрос через форму
            ниже, и&nbsp;наш менеджер связется с вами</p>

        @php $user = Auth::guard('customer')->user() ?? null; @endphp

        {!! Form::open(['url' => route('frontend.nomenclature_request.store'), 'method' => 'post', 'files' => true, 'class' => 'invite__form is-success']) !!}

        <div class="request__input-row">
            <div class="request__input-col">
                <div class="form-input">
                    {!! Form::label('company', 'Название компании*') !!}
                    {!! Form::text('company', old('company', $user?->company->name ?? null), ['id' => 'request-company', 'placeholder' => 'ООО "Электромонтаж"', 'required']) !!}
                    <!-- <span class="is-error">Укажите название компании</span> -->
                    @if ($errors->has('company'))
                        <p class="message-error">{{ $errors->first('company') }}</p>
                    @endif
                </div>
                <div class="form-input">
                    {!! Form::label('name', 'Ваше имя*') !!}
                    {!! Form::text('name', old('name', $user->name ?? null), ['id' => 'request-name', 'placeholder' => 'Иванов Иван', 'required']) !!}
                    @if ($errors->has('name'))
                        <p class="message-error">{{ $errors->first('name') }}</p>
                    @endif
                </div>
                <div class="form-input">
                    {!! Form::label('email', 'Электронная почта*') !!}
                    {!! Form::email('email', old('email', $user->email ?? null), ['id' => 'request-email', 'placeholder' => 'customer@gmail.com', 'required']) !!}
                    @if ($errors->has('email'))
                        <p class="message-error">{{ $errors->first('email') }}</p>
                    @endif
                </div>
                <div class="form-input">
                    {!! Form::label('phone', 'Номер телефона*') !!}
                    {!! Form::tel('phone', old('phone', $user->phone ?? null), ['id' => 'request-phone', 'placeholder' => '+7 900 000-00-00', 'required']) !!}
                    @if ($errors->has('phone'))
                        <p class="message-error">{{ $errors->first('phone') }}</p>
                    @endif
                </div>
            </div>
            <div class="request__input-col">
                <div class="form-input">
                    {!! Form::label('nomenclature', 'Маркировка*') !!}
                    {!! Form::text('nomenclature', old('nomenclature'), ['id' => 'request-label', 'placeholder' => '9999999999999999999999999999', 'required']) !!}
                    @if ($errors->has('nomenclature'))
                        <p class="message-error">{{ $errors->first('nomenclature') }}</p>
                    @endif
                </div>
                <div class="form-input__line">
                    <div class="form-input">
                        {!! Form::label('count', 'Количество*') !!}
                        {!! Form::text('count', old('count'), ['id' => 'request-count', 'placeholder' => '10', 'required']) !!}
                        @if ($errors->has('count'))
                            <p class="message-error">{{ $errors->first('count') }}</p>
                        @endif

                    </div>
                    <div class="form-select">
                        {!! Form::label('unit', 'Ед.упаковки*') !!}
                        <select name="unit" id="request-unit" class="js-select">
                            <option value="0">штука</option>
                            <option value="1">коробка</option>
                        </select>
                        @if ($errors->has('unit'))
                            <p class="message-error">{{ $errors->first('unit') }}</p>
                        @endif
                    </div>
                </div>
                <div class="request__textarea form-input">
                    {!! Form::label('message', 'Комментарий') !!}
                    {!! Form::textarea('message', old('message'), ['id' => "request-message", 'placeholder' => 'Текст комментария']) !!}
                    @if ($errors->has('message'))
                        <p class="message-error">{{ $errors->first('message') }}</p>
                    @endif
                </div>
                <div class="request__input-file form-input-file js-input-file">
                    <label for="request-file" class="btn btn--secondary">
                        <svg aria-hidden="true">
                            <use xlink:href="{{ url('/images/sprite.svg#file-download') }}"></use>
                        </svg>
                        <span>Загрузить файл</span>
                    </label>
                    <input type="file" name="attach" id="request-file" class="sr-only">
                </div>
            </div>
        </div>
        <div class="request__checkbox form-checkbox">
            <input type="checkbox" name="agreement" id="request-agreement">
            <label for="request-agreement">Я даю согласие на обработку персональных данных в&nbsp;соответствии с&nbsp;<a
                        href="{{ route('frontend.page', ['slug' => 'privacy-policy']) }}">Политикой конфиденциальности</a></label>
            @if ($errors->has('agreement'))
                <p class="message-error">{{ $errors->first('agreement') }}</p>
            @endif
        </div>
        <div class="request__btn">
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
                        <span>{{ session('success') }}</span>
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

@endsection

@section('js')

@endsection
