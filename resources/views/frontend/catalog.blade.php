@extends('layouts.frontend')

@section('title', $title)

@section('description', $meta_description)

@section('keywords', $meta_keywords)

@section('seo_url_canonical', $seo_url_canonical)

@section('css')


@endsection

@section('content')

    @include('layouts._breadcrumbs')

    @include('layouts._watched_cards')

@endsection

@section('js')



@endsection

