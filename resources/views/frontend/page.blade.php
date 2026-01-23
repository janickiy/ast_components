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

    @php

    $content = $page->text;

    $content = str_replace('DETAIL_DOWNLOAD_TAG', SettingsHelper::getInstance()->getValueForKey('DETAILS'), $content);

    @endphp

    {!! $content !!}

    @include('layouts._watched_cards')

@endsection

@section('js')


@endsection
