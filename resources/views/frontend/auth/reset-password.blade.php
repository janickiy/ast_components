@extends('layouts.frontend')

@section('title', 'Сброс пароля')

@section('content')

    <div class="reset-password container-xs">
        <div class="reset-password__header">
            <h1>Установка нового пароля</h1>
        </div>

        @if ($errors->any())
            <div class="alert alert--error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {!! Form::open(['url' => route('frontend.auth.password.update'), 'method' => 'post', 'class' => 'reset-password__form']) !!}
            {!! Form::hidden('token', $token) !!}
            {!! Form::hidden('email', $email) !!}

            <div class="form-password">
                {!! Form::label('password', 'Новый пароль*') !!}
                {!! Form::password('password', ['id' => 'password', 'placeholder' => '*******', 'required' => true]) !!}
                @if ($errors->has('password'))
                    <p class="text-danger">{{ $errors->first('password') }}</p>
                @endif
            </div>

            <div class="form-password">
                {!! Form::label('password_confirmation', 'Подтвердите пароль*') !!}
                {!! Form::password('password_confirmation', ['id' => 'password_confirmation', 'placeholder' => '*******', 'required' => true]) !!}
            </div>

            <div class="reset-password__btn">
                <button type="submit" class="btn btn--primary">
                    <svg aria-hidden="true">
                        <use xlink:href="{{ url('/images/sprite.svg#save') }}"></use>
                    </svg>
                    <span>Сохранить пароль</span>
                </button>
            </div>
        {!! Form::close() !!}
    </div>

@endsection
