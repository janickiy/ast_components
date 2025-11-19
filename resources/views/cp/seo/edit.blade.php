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
                        {!! Form::open(['url' => route('cp.seo.update'), 'method' => 'put']) !!}

                        {!! isset($row) ? Form::hidden('id', $row->id) : '' !!}

                        <div class="card-body">

                            <p>*-обязательные поля</p>

                            <div class="form-group">

                                {!! Form::label('type', 'Страница') !!}

                                {!! Form::text('type', old('type', $row->type ?? null), ['class' => 'form-control', 'readonly']) !!}

                                @if ($errors->has('type'))
                                    <p class="text-danger">{{ $errors->first('type') }}</p>
                                @endif

                            </div>

                            <div class="form-group">

                                {!! Form::label('h1', 'h1', ['class' => 'label']) !!}

                                {!! Form::text('h1', old('h1', $row->h1 ?? null), ['class' => 'form-control']) !!}

                                @if ($errors->has('h1'))
                                    <p class="text-danger">{{ $errors->first('h1') }}</p>
                                @endif

                            </div>

                            <div class="form-group">

                                {!! Form::label('title', 'title') !!}

                                {!! Form::text('title', old('title', $row->title ?? null), ['class' => 'form-control']) !!}

                                @if ($errors->has('title'))
                                    <p class="text-danger">{{ $errors->first('title') }}</p>
                                @endif

                            </div>

                            <div class="form-group">

                                {!! Form::label('keyword', 'Keyword') !!}

                                {!! Form::textarea('keyword', old('keyword', $row->keyword ?? null), ['rows' => "3", 'class' => 'custom-scroll']) !!}

                                @if ($errors->has('keyword'))
                                    <p class="text-danger">{{ $errors->first('keyword') }}</p>
                                @endif

                            </div>

                            <div class="form-group">

                                {!! Form::label('description', 'Description') !!}

                                {!! Form::textarea('description', old('description', isset($row) ? $row->description : null), ['rows' => "3", 'class' => 'form-control']) !!}

                                @if ($errors->has('description'))
                                    <p class="text-danger">{{ $errors->first('description') }}</p>
                                @endif

                            </div>

                            <div class="form-group">

                                {!! Form::label('url_canonical', 'Url canonical') !!}

                                {!! Form::text('url_canonical', old('url_canonical', $row->url_canonical ?? null), ['class' => 'form-control']) !!}

                                @if ($errors->has('url_canonical'))
                                    <p class="text-danger">{{ $errors->first('url_canonical') }}</p>
                                @endif

                            </div>

                            <div class="form-check">

                                {!! Form::checkbox('seo_sitemap', 1, isset($row) ? ($row->seo_sitemap === true ? 1 : 0): 1) !!}

                                {!! Form::label('seo_sitemap', 'Публиковать', ['class' => 'form-check-label']) !!}

                                @if ($errors->has('seo_sitemap'))
                                    <span class="text-danger">{{ $errors->first('seo_sitemap') }}</span>
                                @endif

                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                {{ isset($row) ? 'редактировать' : 'добавить' }}
                            </button>
                            <a class="btn btn-default float-sm-right" href="{{ route('admin.news.index') }}">
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

            $("#title").on("change keyup input click", function () {
                if (this.value.length >= 2) {
                    let name = this.value;
                    let request = $.ajax({
                        url: '{!! route('admin.ajax') !!}',
                        method: "POST",
                        data: {
                            action: "get_news_slug",
                            name: name
                        },
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        dataType: "json"
                    });
                    request.done(function (data) {
                        if (data.slug != null && data.slug !== '') {
                            $("#slug").val(data.slug);
                        }
                    });
                }
                console.log(html);
            });
        });
    </script>

@endsection
