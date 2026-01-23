@extends('app')

@section('title', $title)

@section('css')

    <!-- summernote -->
    {!! Html::style('/plugins/summernote/summernote-bs4.min.css') !!}
    <!-- CodeMirror -->
    {!! Html::style('/plugins/codemirror/codemirror.css') !!}
    {!! Html::style('/plugins/codemirror/theme/monokai.css') !!}

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
                        {!! Form::open(['url' => isset($row) ? route('admin.product_documents.update') : route('admin.product_documents.store'), 'files' => true, 'method' => isset($row) ? 'put' : 'post']) !!}

                        {!! isset($row) ? Form::hidden('id', $row->id) : '' !!}

                        {!! Form::hidden('product_id', $product_id) !!}

                        <div class="card-body">

                            <p>*-обязательные поля</p>

                            <div class="form-group">
                                {!! Form::label('name', 'Название*') !!}
                                {!! Form::text('name', old('name', $row->name ?? null), ['class' => 'form-control']) !!}
                                @if ($errors->has('name'))
                                    <p class="text-danger">{{ $errors->first('name') }}</p>
                                @endif
                            </div>

                            <div class="form-group">

                                {!! Form::label('file', 'Документ*') !!}

                                <div class="input-group">
                                    <div class="custom-file">
                                        {!! Form::file('file',  ['class' => 'custom-file-input']) !!}

                                        {!! Form::label('file', 'Выберите файл (doc,docx,pdf,xls,xlsx,odt,ods)', ['class' => 'custom-file-label']) !!}
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Обзор...</span>
                                    </div>
                                </div>

                                @if ($errors->has('file'))
                                    <span class="text-danger">{{ $errors->first('file') }}</span>
                                @endif

                                <div class="note">
                                    Максимальный размер: <strong>{{ $maxUploadFileSize }}</strong>
                                </div>

                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                {{ isset($row) ? 'Изменить' : 'Добавить' }}
                            </button>
                            <a class="btn btn-default float-sm-right"
                               href="{{ route('admin.product_documents.index', ['product_id' => $product_id]) }}">
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

    <!-- Summernote -->
    {!! Html::script('/plugins/summernote/summernote-bs4.min.js') !!}

    <!-- CodeMirror -->
    {!! Html::script('/plugins/codemirror/codemirror.js') !!}
    {!! Html::script('/plugins/codemirror/mode/css/css.js') !!}
    {!! Html::script('/plugins/codemirror/mode/xml/xml.js') !!}
    {!! Html::script('/plugins/codemirror/mode/htmlmixed/htmlmixed.js') !!}
    {!! Html::script('/plugins/bs-custom-file-input/bs-custom-file-input.min.js') !!}
    {!! Html::script('/plugins/bs-custom-file-input/bs-custom-file-input.min.js') !!}

    <!-- Page specific script -->
    <script>
        $(document).ready(function () {
            // Summernote
            $('#summernote').summernote()
            bsCustomFileInput.init();
        });
    </script>

@endsection
