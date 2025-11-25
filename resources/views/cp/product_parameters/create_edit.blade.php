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
                        {!! Form::open(['url' => isset($row) ? route('admin.product_parameters.update') : route('admin.product_parameters.store'), 'method' => isset($row) ? 'put' : 'post']) !!}

                        {!! isset($row) ? Form::hidden('id', $row->id) : '' !!}

                        {!! Form::hidden('product_id', $product_id) !!}

                        <div class="card-body">

                            <p>*-обязательные поля</p>

                            <div class="form-group">

                                {!! Form::label('name', 'Название*') !!}

                                {!! Form::text('name', old('title', $row->name ?? null), ['class' => 'form-control']) !!}

                                @if ($errors->has('name'))
                                    <p class="text-danger">{{ $errors->first('name') }}</p>
                                @endif

                            </div>

                            <div class="form-group">

                                {!! Form::label('value', 'Название*') !!}

                                {!! Form::text('value', old('title', $row->value ?? null), ['class' => 'form-control']) !!}

                                @if ($errors->has('value'))
                                    <p class="text-danger">{{ $errors->first('value') }}</p>
                                @endif

                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                {{ isset($row) ? 'редактировать' : 'добавить' }}
                            </button>
                            <a class="btn btn-default float-sm-right" href="{{ route('admin.product_parameters.index', ['product_id' => $product_id]) }}">
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
