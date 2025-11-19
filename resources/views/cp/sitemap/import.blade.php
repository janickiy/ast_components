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
                        {!! Form::open(['url' => route('admin.sitemap.import'), 'files' => true, 'method' => 'post']) !!}

                        <div class="card-body">

                            <p>*-обязательные поля</p>

                            <div class="form-group">

                                <div class="input-group">
                                    <div class="custom-file">
                                        {!! Form::file('file',  [ 'class' => 'custom-file-input']) !!}

                                        {!! Form::label('file', 'Файл sitemap.xml*', ['class' => 'custom-file-label']) !!}
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Обзор...</span>
                                    </div>
                                </div>

                                @if ($errors->has('file'))
                                    <span class="text-danger">{{ $errors->first('file') }}</span>
                                @endif

                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                Загрузить
                            </button>
                            <a class="btn btn-default float-sm-right" href="{{ route('admin.sitemap.index') }}">
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
