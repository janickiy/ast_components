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
                        {!! Form::open(['url' => route('admin.complaints.update'), 'method' => 'put']) !!}

                        {!! isset($row) ? Form::hidden('id', $row->id) : '' !!}

                        <div class="card-body">

                            <p>*-обязательные поля</p>

                            <div class="form-group">
                                {!! Form::label('name', 'Имя') !!}
                                {!! Form::text('name', $row?->customer?->name, ['disabled' => "disabled", 'class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('email', 'Email') !!}
                                {!! Form::text('email', $row?->customer?->email, ['disabled' => "disabled", 'class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('phone', 'Телефон') !!}
                                {!! Form::text('phone', $row?->customer?->phone, ['disabled' => "disabled", 'class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('phone', '') !!}
                                {!! Form::text('phone', $row?->customer?->phone, ['disabled' => "disabled", 'class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('result', 'Результат рассмотрения') !!}
                                {!! Form::textarea('result', old('result', $row->result ?? null), ['rows' => "5", 'class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('status', 'Статус*') !!}
                                {!! Form::select('status', $options, old('status', $row->status ?? 0), ['placeholder' => 'Статус', 'class' => 'custom-select']) !!}
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
                            <a class="btn btn-default float-sm-right" href="{{ route('admin.complaints.index') }}">
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
