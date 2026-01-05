@extends('layouts.frontend')

@section('title', $title)

@section('description', $meta_description)

@section('keywords', $meta_keywords)

@section('seo_url_canonical', $seo_url_canonical)

@section('content')

    @include('layouts._breadcrumbs')

    <div class="profile-edit container-xs">
        <div class="profile-edit__header">
            <h1>{{ $h1 }}</h1>
        </div>

        {!! Form::model($user, ['url' => route('frontend.profile.update'), 'method' => 'put', 'class' => 'profile-edit__form']) !!}

            <div class="form-input">
                {!! Form::label('name', 'Ваше имя*') !!}
                {!! Form::text('name', null, ['id' => 'name', 'placeholder' => 'Иван Иванов', 'required' => true]) !!}
                @if ($errors->has('name'))
                    <p class="text-danger">{{ $errors->first('name') }}</p>
                @endif
            </div>

            <div class="form-input">
                {!! Form::label('email', 'Email') !!}
                {!! Form::email('email', null, ['id' => 'email', 'disabled' => true]) !!}
                <small class="form-hint">Email нельзя изменить</small>
            </div>

            <div class="profile-edit__btns">
                <button type="submit" class="btn btn--primary">
                    <svg aria-hidden="true">
                        <use xlink:href="{{ url('/images/sprite.svg#save') }}"></use>
                    </svg>
                    <span>Сохранить</span>
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
