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

                                <a class="btn btn-success" href="{{ route('admin.sitemap.export') }}" target="_blank" download="sitemap.xml">Выгрузить карту sitemap.xml</a>

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
