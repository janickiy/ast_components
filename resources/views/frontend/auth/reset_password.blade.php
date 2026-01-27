@extends('layouts.frontend')

@section('title', $title)

@section('css')


@endsection

@section('content')

    <div class="request container-xs">
        <div class="modal__content">
            <div class="modal__title">
                <h2>{{ $title }}</h2>
            </div>

            {!! Form::open(['url' => route('frontend.password.set_new'), 'method' => 'post', 'class' => 'modal__form']) !!}

            {!! Form::hidden('token', $token) !!}

            {!! Form::hidden('email', $email) !!}

            <div class="form-password">
                {!! Form::label('password', 'Пароль*') !!}
                {!! Form::password('password', ['id' => "reset-password", 'placeholder' => '*******', 'required' => 'required']) !!}
                <div class="form-display-btn">
                    <input type="checkbox" id="sign-up-display-password">
                    <label for="sign-up-display-password">Показать пароль</label>
                </div>
                @if ($errors->has('password'))
                    <p class="text-danger">{{ $errors->first('password') }}</p>
                @endif
            </div>
            <div class="form-password">
                {!! Form::label('password-again', 'Повтор пароля*') !!}
                {!! Form::password('password-again', ['id' => "reset-password-again", 'placeholder' => '*******', 'required' => 'required']) !!}
                <div class="form-display-btn">
                    <input type="checkbox" id="sign-up-display-password-again">
                    <label for="sign-up-display-password-again">Показать пароль</label>
                </div>
                @if ($errors->has('password-again'))
                    <p class="text-danger">{{ $errors->first('password-again') }}</p>
                @endif
            </div>
            <div class="request__btn">
                <button type="submit" class="btn btn--primary">
                    <span>Изменить</span>
                </button>
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
