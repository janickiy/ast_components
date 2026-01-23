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
                        {!! Form::open(['url' => isset($row) ? route('admin.redirect.update') : route('admin.redirect.store'), 'files' => true, 'method' => isset($row) ? 'put' : 'post']) !!}

                        {!! isset($row) ? Form::hidden('id', $row->id) : '' !!}

                        <div class="card-body">
                            <p>*-обязательные поля</p>
                            <div class="form-group">
                                {!! Form::label('from', 'from*') !!}
                                {!! Form::text('from', old('title', $row->from ?? null), ['class' => 'form-control']) !!}
                                @if ($errors->has('from'))
                                    <p class="text-danger">{{ $errors->first('from') }}</p>
                                @endif
                            </div>

                            <div class="form-group">
                                {!! Form::label('to', 'to*') !!}
                                {!! Form::text('to', old('to', $row->to ?? null), ['class' => 'form-control']) !!}
                                @if ($errors->has('to'))
                                    <p class="text-danger">{{ $errors->first('to') }}</p>
                                @endif
                            </div>

                            <div class="form-group">
                                {!! Form::label('status', 'Статус*') !!}
                                {!! Form::select('status', ['301' => '301', '302' => '302'], $row->status ?? '301', ['placeholder' => 'Статус', 'class' => 'custom-select']) !!}
                                @if ($errors->has('status'))
                                    <p class="text-danger">{{ $errors->first('status') }}</p>
                                @endif
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                {{ isset($row) ? 'редактировать' : 'добавить' }}
                            </button>
                            <a class="btn btn-default float-sm-right" href="{{ route('admin.redirect.index') }}">
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
