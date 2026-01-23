@extends('app')

@section('title', $title)

@section('css')

    <!-- summernote -->
    {!! Html::style('/plugins/summernote/summernote-bs4.min.css') !!}
    <!-- CodeMirror -->
    {!! Html::style('/plugins/codemirror/codemirror.css') !!}
    {!! Html::style('/plugins/codemirror/theme/monokai.css') !!}

    <!-- Tempusdominus Bootstrap 4 -->
    {!! Html::style('/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') !!}

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
                        {!! Form::open(['url' => route('admin.orders.update'), 'files' => true, 'method' => 'put']) !!}

                        {!! isset($row) ? Form::hidden('id', $row->id) : '' !!}

                        <div class="card-body">

                            <p>*-обязательные поля</p>

                            <div class="form-group">

                                {!! Form::label('delivery_date', 'Ожидаемая дата доставки') !!}

                                <div class="input-group date" id="reservationdatetime" data-target-input="nearest">

                                    {!! Form::text('delivery_date', old('delivery_date', $row->deliveryEditDateFormat() ?? null), ['data-target' => '#reservationdatetime', 'class' => 'form-control datetimepicker-input']) !!}

                                    <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>

                                @if ($errors->has('delivery_date'))
                                    <p class="text-danger">{{ $errors->first('delivery_date') }}</p>
                                @endif

                            </div>

                            <div class="form-group">
                                {!! Form::label('status', 'Статус*') !!}
                                {!! Form::select('status', $options, $row->status ?? 0, ['placeholder' => 'Статус', 'class' => 'custom-select']) !!}
                                @if ($errors->has('status'))
                                    <p class="text-danger">{{ $errors->first('status') }}</p>
                                @endif

                            </div>

                            <div class="form-group">

                                {!! Form::label('invoice', 'Счет') !!}

                                <div class="input-group">
                                    <div class="custom-file">
                                        {!! Form::file('invoice',  [ 'class' => 'custom-file-input']) !!}
                                        {!! Form::label('invoice', 'Выберите файл (pdf,doc,docx,jpg,jpeg,png)', ['class' => 'custom-file-label']) !!}
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Обзор...</span>
                                    </div>
                                </div>

                                @if ($errors->has('invoice'))
                                    <span class="text-danger">{{ $errors->first('invoice') }}</span>
                                @endif

                                <div class="note">
                                    Максимальный размер: <strong>{{ $maxUploadFileSize }}</strong>
                                </div>

                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                редактировать
                            </button>
                            <a class="btn btn-default float-sm-right" href="{{ route('admin.orders.index') }}">
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

    <!-- Bootstrap4 Duallistbox -->
    {!! Html::script('/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') !!}
    {!! Html::script('/plugins/moment/moment.min.js') !!}

    <!-- Tempusdominus Bootstrap 4 -->
    {!! Html::script('/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') !!}

    <script>

        $(document).ready(function () {
            // Summernote
            $('#summernote').summernote()
            bsCustomFileInput.init();

            // Date and time picker
            $('#reservationdatetime').datetimepicker({
                icons: { time: 'far fa-clock' },
                format: 'DD/MM/YYYY'
            });
        });

    </script>

@endsection
