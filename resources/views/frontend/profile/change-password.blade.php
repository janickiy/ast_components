@extends('layouts.frontend')

@section('title', $title)

@section('description', $meta_description)

@section('keywords', $meta_keywords)

@section('seo_url_canonical', $seo_url_canonical)

@section('content')

    @include('layouts._breadcrumbs')

    <div class="change-password container-xs">
        <div class="change-password__header">
            <h1>{{ $h1 }}</h1>
        </div>

        {!! Form::open(['url' => route('frontend.profile.password.update'), 'method' => 'put', 'class' => 'change-password__form']) !!}

            <div class="form-password">
                {!! Form::label('current_password', 'Текущий пароль*') !!}
                {!! Form::password('current_password', ['id' => 'current_password', 'placeholder' => '*******', 'required' => true]) !!}
                @if ($errors->has('current_password'))
                    <p class="text-danger">{{ $errors->first('current_password') }}</p>
                @endif
            </div>

            <div class="form-password">
                {!! Form::label('password', 'Новый пароль*') !!}
                {!! Form::password('password', ['id' => 'password', 'placeholder' => '*******', 'required' => true]) !!}
                @if ($errors->has('password'))
                    <p class="text-danger">{{ $errors->first('password') }}</p>
                @endif
            </div>

            <div class="form-password">
                {!! Form::label('password_confirmation', 'Подтвердите новый пароль*') !!}
                {!! Form::password('password_confirmation', ['id' => 'password_confirmation', 'placeholder' => '*******', 'required' => true]) !!}
            </div>

            <div class="change-password__btns">
                <button type="submit" class="btn btn--primary">
                    <svg aria-hidden="true">
                        <use xlink:href="{{ url('/images/sprite.svg#save') }}"></use>
                    </svg>
                    <span>Сохранить пароль</span>
                </button>
                <a href="{{ route('frontend.profile.index') }}" class="btn btn--secondary">
                    <svg aria-hidden="true">
                        <use xlink:href="{{ url('/images/sprite.svg#back') }}"></use>
                    </svg>
                    <span>Назад</span>
                </a>
            </div>

        {!! Form::close() !!}
    </div>

@endsection
