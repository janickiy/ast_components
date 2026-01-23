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
                        {!! Form::open(['url' => route('admin.customers.update'), 'method' => 'put']) !!}

                        {!! isset($row) ? Form::hidden('id', $row->id) : '' !!}

                        <div class="card-body">

                            <p>*-обязательные поля</p>

                            <div class="form-group">
                                {!! Form::label('name', 'имя*') !!}
                                {!! Form::text('name', old('name', $row->name ?? null), ['class' => 'form-control', 'placeholder' => 'имя']) !!}
                                @if ($errors->has('name'))
                                    <p class="text-danger">{{ $errors->first('name') }}</p>
                                @endif
                            </div>

                            <div class="form-group">
                                {!! Form::label('phone', 'телефон') !!}
                                {!! Form::text('phone', old('phone', $row->phone ?? null), ['class' => 'form-control', 'placeholder' => 'имя']) !!}
                                @if ($errors->has('phone'))
                                    <p class="text-danger">{{ $errors->first('phone') }}</p>
                                @endif
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                               редактировать
                            </button>
                            <a class="btn btn-default float-sm-right" href="{{ route('admin.customers.index') }}">
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
