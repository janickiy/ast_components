@extends('app')

@section('title', $title)

@section('css')


@endsection

@section('content')

    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <!-- general form elements -->
                    <header class="card card-primary">

                        <!-- form start -->
                        {!! Form::open(['url' => route('admin.seo.update'), 'method' => 'put']) !!}

                        {!! isset($row) ? Form::hidden('id', $row->id) : '' !!}

                        <div class="card-body">

                            <p>*-обязательные поля</p>

                            <div class="form-group">
                                {!! Form::label('type', 'Страница') !!}
                                {!! Form::text('type', old('type', $row->type ?? null), ['class' => 'form-control', 'readonly']) !!}
                                @if ($errors->has('type'))
                                    <p class="text-danger">{{ $errors->first('type') }}</p>
                                @endif

                            </div>

                            <div class="form-group">
                                {!! Form::label('h1', 'h1', ['class' => 'label']) !!}
                                {!! Form::text('h1', old('h1', $row->h1 ?? null), ['class' => 'form-control']) !!}
                                @if ($errors->has('h1'))
                                    <p class="text-danger">{{ $errors->first('h1') }}</p>
                                @endif

                            </div>

                            <div class="form-group">
                                {!! Form::label('title', 'title') !!}
                                {!! Form::text('title', old('title', $row->title ?? null), ['class' => 'form-control']) !!}
                                @if ($errors->has('title'))
                                    <p class="text-danger">{{ $errors->first('title') }}</p>
                                @endif

                            </div>

                            <div class="form-group">
                                {!! Form::label('keyword', 'Keyword') !!}
                                {!! Form::textarea('keyword', old('keyword', $row->keyword ?? null), ['rows' => "3", 'class' => 'form-control']) !!}
                                @if ($errors->has('keyword'))
                                    <p class="text-danger">{{ $errors->first('keyword') }}</p>
                                @endif

                            </div>

                            <div class="form-group">
                                {!! Form::label('description', 'Description') !!}
                                {!! Form::textarea('description', old('description', isset($row) ? $row->description : null), ['rows' => "3", 'class' => 'form-control']) !!}
                                @if ($erros->has('description'))
                                    <p class="text-danger">{{ $errors->first('description') }}</p>
                                @endif

                            </div>

                            <div class="form-group">
                                {!! Form::label('url_canonical', 'Url canonical') !!}
                                {!! Form::text('url_canonical', old('url_canonical', $row->url_canonical ?? null), ['class' => 'form-control']) !!}
                                @if ($errors->has('url_canonical'))
                                    <p class="text-danger">{{ $errors->first('url_canonical') }}</p>
                                @endif

                            </div>

                            <div class="form-check">
                                {!! Form::checkbox('seo_sitemap', 1, isset($row) ? ($row->seo_sitemap): 0, ['class' => 'form-check-input']) !!}
                                {!! Form::label('seo_sitemap', 'Публиковать', ['class' => 'form-check-label']) !!}
                                @if ($errors->has('seo_sitemap'))
                                    <p class="text-danger">{{ $errors->first('seo_sitemap') }}</p>
                                @endif

                            </div>


                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                {{ isset($row) ? 'редактировать' : 'добавить' }}
                            </button>
                            <a class="btn btn-default float-sm-right" href="{{ route('admin.seo.index') }}">
                                назад
                            </a>
                        </div>

                        {!! Form::close() !!}

                    </header>

                </div>
                <!-- /.card -->
            </div>
        </div>

    </section>
    <!-- /.content -->

@endsection

@section('js')


@endsection
