@extends('layouts.frontend')

@section('title', $title)

@section('description', $meta_description)

@section('keywords', $meta_keywords)

@section('seo_url_canonical', $seo_url_canonical)

@section('css')

@endsection

@section('content')

    @include('layouts._breadcrumbs')

    <div class="invite container-xs">
        <p class="invite__description">Оставьте свои данные, и наш специалист по тендерам свяжется с вами</p>

        {!! Form::open(['url' => route('frontend.send_invite'), 'method' => 'post', 'class' => 'invite__form is-success']) !!}

            <div class="invite__input-row">

                <div class="invite__input-col">

                    @if (session('error'))
                    <span style="color: red;">
                        <span>{{ session('error') }}</span>
                    </span>
                    @endif

                    <div class="form-input">
                        {!! Form::label('company', 'Название компании*') !!}
                        {!! Form::text('company', old('company'), ['id' => 'invite-company', 'placeholder' => 'ООО "Электромонтаж"', 'required']) !!}
                        @if ($errors->has('company'))
                            <p class="text-danger">{{ $errors->first('company') }}</p>
                        @endif
                        <!-- <span class="is-error">Укажите название компании</span> -->
                    </div>
                    <div class="form-input">
                        {!! Form::label('name', 'Ваше имя*') !!}
                        {!! Form::text('name', old('name'), ['id' => 'name', 'placeholder' => 'Иванов Иван', 'required']) !!}
                        @if ($errors->has('name'))
                            <p class="text-danger">{{ $errors->first('name') }}</p>
                        @endif
                    </div>
                    <div class="form-input">
                        {!! Form::label('email', 'Электронная почта*') !!}
                        {!! Form::email('email', old('email'), ['id' => 'invite-email', 'placeholder' => 'customer@gmail.com', 'required']) !!}
                        @if ($errors->has('email'))
                            <p class="text-danger">{{ $errors->first('email') }}</p>
                        @endif
                    </div>
                    <div class="form-input">
                        {!! Form::label('phone', 'Номер телефона*') !!}
                        {!! Form::tel('phone', old('phone'), ['id' => 'invite-phone', 'placeholder' => '+7 900 000-00-00', 'required']) !!}
                        @if ($errors->has('phone'))
                            <p class="text-danger">{{ $errors->first('phone') }}</p>
                        @endif
                    </div>
                </div>
                <div class="invite__input-col">
                    <div class="form-select">
                        {!! Form::label('platform', 'Площадка*') !!}
                        {!! Form::select('platform', $options, old('platform'), ['class' => 'js-select']) !!}
                        @if ($errors->has('platform'))
                            <p class="text-danger">{{ $errors->first('platform') }}</p>
                        @endif
                    </div>
                    <div class="form-input">
                        {!! Form::label('numb', 'Номер извещения о закупочной процедуре*') !!}
                        {!! Form::text('numb', old('numb'), ['required' => true, 'id' => 'invite-numb', 'placeholder' => '9999999999999999999999999999']) !!}
                        @if ($errors->has('numb'))
                            <p class="text-danger">{{ $errors->first('numb') }}</p>
                        @endif
                    </div>
                    <div class="invite__textarea form-input">
                        {!! Form::label('message', 'Комментарий') !!}
                        {!! Form::textarea('message', old('message'), ['id' => "invite-message", 'placeholder' => 'Текст комментария']) !!}
                        @if ($errors->has('message'))
                            <p class="text-danger">{{ $errors->first('message') }}</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="invite__checkbox form-checkbox">
                <input type="checkbox" id="invite-agreement">
                <label for="invite-agreement">Я даю согласие на обработку персональных данных в&nbsp;соответствии с&nbsp;<a href="{{ route('frontend.page', ['slug' => 'privacy-policy']) }}">Политикой конфиденциальности</a></label>
            </div>
            <div class="invite__btn">
                <button type="submit" class="btn btn--primary">
                    <svg aria-hidden="true">
                        <use xlink:href="{{  url('/images/sprite.svg#mail') }}"></use>
                    </svg>
                    <span>Отправить</span>
                </button>
                @if (session('success'))
                <span class="success-message">
                        <svg aria-hidden="true">
                            <use xlink:href="{{ url('/images/sprite.svg#check-circle') }}"></use>
                        </svg>
                        <span>Ваше приглашение успешно отправлено</span>
                </span>
                @endif
            </div>

        {!! Form::close() !!}
    </div>

@endsection

@section('js')

@endsection