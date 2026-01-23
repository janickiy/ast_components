@extends('app')

@section('title', $title)

@section('css')

@endsection

@section('content')

    <!-- Main content -->
    <section class="content">

        <!-- Main content -->
        <section class="content">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="pb-3">
                                    <a href="{{ route('admin.catalog.create') }}" class="btn btn-info btn-sm pull-left">
                                        <span class="fa fa-plus"> &nbsp;</span> Добавить
                                    </a>
                                </div>

                                {!! \App\Models\Catalog::buildTree($catalogsList,0) !!}

                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->

        </section>
        <!-- /.content -->

@endsection

@section('js')


@endsection