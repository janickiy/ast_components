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
                        {!! Form::open(['url' => route('admin.feedback.update'), 'method' => 'put']) !!}

                        {!! isset($row) ? Form::hidden('id', $row->id) : '' !!}

                        <div class="card-body">

                            <p>*-обязательные поля</p>

                            <div class="form-group">
                                {!! Form::label('name', 'Имя') !!}
                                {!! Form::text('name', $row->name ?? null, ['disabled' => "disabled", 'class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('email', 'Email') !!}
                                {!! Form::text('email', $row->email ?? null, ['disabled' => "disabled", 'class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('phone', 'Телефон') !!}
                                {!! Form::text('phone', $row->phone ?? null, ['disabled' => "disabled", 'class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('phone', '') !!}
                                {!! Form::text('phone', $row->phone ?? null, ['disabled' => "disabled", 'class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('message', 'Описание*') !!}
                                {!! Form::textarea('message', $row->message ?? null, ['disabled' => "disabled", 'rows' => "5", 'class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('status', 'Статус*') !!}
                                {!! Form::select('status', $options, $row->status ?? 0, ['placeholder' => 'Статус', 'class' => 'custom-select']) !!}
                                @if ($errors->has('status'))
                                    <p class="text-danger">{{ $errors->first('status') }}</p>
                                @endif
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                редактировать
                            </button>
                            <a class="btn btn-default float-sm-right" href="{{ route('admin.feedback.index') }}">
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
