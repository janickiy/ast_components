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
                        {!! Form::open() !!}

                        <div class="card-body">

                            <div class="form-group">
                                {!! Form::label('name', 'Имя') !!}
                                {!! Form::text('name', $row->name, ['disabled' => "disabled", 'class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('email', 'Email') !!}
                                {!! Form::text('email', $row->email, ['disabled' => "disabled", 'class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('phone', 'Телефон') !!}
                                {!! Form::text('phone', $row->phone, ['disabled' => "disabled", 'class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('company', 'Компания') !!}
                                {!! Form::text('company', $row->company, ['disabled' => "disabled", 'class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('platform', 'Площадка') !!}
                                {!! Form::text('platform', $row->platform, ['disabled' => "disabled", 'class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('numb', 'Номер извещения') !!}
                                {!! Form::text('numb', $row->numb, ['disabled' => "disabled", 'class' => 'form-control']) !!}
                            </div>


                            <div class="form-group">
                                {!! Form::label('ip', 'IP') !!}
                                {!! Form::text('ip', $row->ip, ['disabled' => "disabled", 'class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('message', 'Сообщение') !!}
                                {!! Form::textarea('message',  $row->message, ['disabled' => "disabled", 'rows' => "5", 'class' => 'form-control']) !!}
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <a class="btn btn-default float-sm-right" href="{{ route('admin.invites.index') }}">
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
