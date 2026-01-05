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
                        {!! Form::open(['url' => isset($row) ? route('admin.manufacturers.update') : route('admin.manufacturers.store'), 'files' => true, 'method' => isset($row) ? 'put' : 'post']) !!}

                        {!! isset($row) ? Form::hidden('id', $row->id) : '' !!}

                        <div class="card-body">

                            <p>*-обязательные поля</p>

                            <div class="form-group">

                                {!! Form::label('title', 'Название*') !!}

                                {!! Form::text('title', old('title', $row->title ?? null), ['class' => 'form-control']) !!}

                                @if ($errors->has('title'))
                                    <p class="text-danger">{{ $errors->first('title') }}</p>
                                @endif

                            </div>

                            <div class="form-group">

                                {!! Form::label('description', 'Описание*') !!}

                                {!! Form::textarea('description', old('description', $row->description ?? null), ['rows' => "3", 'placeholder' => "Описание",  'id' => 'summernote', 'style' => "display: none;"]) !!}

                                @if ($errors->has('description'))
                                    <p class="text-danger">{{ $errors->first('description') }}</p>
                                @endif

                            </div>

                            <div class="form-group">

                                {!! Form::label('country', 'Страна') !!}

                                {!! Form::text('country', old('country', $row->country ?? null), ['class' => 'form-control']) !!}

                                @if ($errors->has('country'))
                                    <p class="text-danger">{{ $errors->first('country') }}</p>
                                @endif

                            </div>

                            <div class="form-group">

                                {!! Form::label('image', 'Фото') !!}

                                <div class="input-group">
                                    <div class="custom-file">
                                        {!! Form::file('image',  [ 'class' => 'custom-file-input']) !!}

                                        {!! Form::label('image', 'Выберите файл*', ['class' => 'custom-file-label']) !!}
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Обзор...</span>
                                    </div>
                                </div>

                                <br>
                                @if (isset($row) && !empty($row->image))
                                    <img src='{{ url($row->getImage()) }}' width="150">
                                @endif

                                @if ($errors->has('image'))
                                    <span class="text-danger">{{ $errors->first('image') }}</span>
                                @endif

                            </div>

                            <div class="form-group">

                                {!! Form::label('image_title', 'IMAGE TITLE') !!}

                                {!! Form::text('image_title', old('image_title', $row->image_title ?? null), ['class' => 'form-control']) !!}

                                @if ($errors->has('image_title'))
                                    <p class="text-danger">{{ $errors->first('image_title') }}</p>
                                @endif

                            </div>

                            <div class="form-group">

                                {!! Form::label('image_alt', 'IMAGE ALT') !!}

                                {!! Form::text('image_alt', old('image_alt', $row->image_alt ?? null), ['class' => 'form-control']) !!}

                                @if ($errors->has('image_alt'))
                                    <p class="text-danger">{{ $errors->first('image_alt') }}</p>
                                @endif

                            </div>

                            <div class="form-group">

                                {!! Form::label('slug', 'ЧПУ*') !!}

                                {!! Form::text('slug', old('slug', $row->slug ?? null), ['class' => 'form-control', 'id' => 'slug']) !!}

                                @if ($errors->has('slug'))
                                    <p class="text-danger">{{ $errors->first('slug') }}</p>
                                @endif

                            </div>

                            <div class="form-group">

                                {!! Form::label('meta_title', 'Seo title') !!}

                                {!! Form::text('meta_title', old('meta_title', $row->meta_title ?? null), ['class' => 'form-control']) !!}

                                @if ($errors->has('meta_title'))
                                    <p class="text-danger">{{ $errors->first('meta_title') }}</p>
                                @endif

                            </div>

                            <div class="form-group">

                                {!! Form::label('meta_title', 'Meta description') !!}

                                {!! Form::textarea('meta_description', old('meta_description', $row->meta_description ?? null), ['rows' => "3", 'class' => 'form-control']) !!}


                                @if ($errors->has('meta_description'))
                                    <p class="text-danger">{{ $errors->first('meta_description') }}</p>
                                @endif

                            </div>

                            <div class="form-group">

                                {!! Form::label('meta_keywords', 'Meta keywords') !!}

                                {!! Form::textarea('meta_keywords', old('meta_keywords', $row->meta_keywords ?? null), ['rows' => "3", 'class' => 'form-control']) !!}

                                @if ($errors->has('meta_keywords'))
                                    <p class="text-danger">{{ $errors->first('meta_keywords') }}</p>
                                @endif

                            </div>

                            <div class="form-group">

                                {!! Form::label('seo_h1', 'Seo h1') !!}

                                {!! Form::text('seo_h1', old('seo_h1', $row->seo_h1 ?? null), ['class' => 'form-control']) !!}

                                @if ($errors->has('seo_h1'))
                                    <p class="text-danger">{{ $errors->first('seo_h1') }}</p>
                                @endif

                            </div>

                            <div class="form-group">

                                {!! Form::label('seo_url_canonical', 'Seo url canonical') !!}

                                {!! Form::text('seo_url_canonical', old('seo_url_canonical', $row->seo_url_canonical ?? null), ['class' => 'form-control']) !!}

                                @if ($errors->has('seo_url_canonical'))
                                    <p class="text-danger">{{ $errors->first('seo_url_canonical') }}</p>
                                @endif

                            </div>

                            <div class="form-check">

                                {!! Form::checkbox('seo_sitemap', 1, isset($row) ? ($row->seo_sitemap): 1, ['class' => 'form-check-input']) !!}

                                {!! Form::label('seo_sitemap', 'Отображать в карте сайта', ['class' => 'form-check-label']) !!}

                                @if ($errors->has('seo_sitemap'))
                                    <p class="text-danger">{{ $errors->first('seo_sitemap') }}</p>
                                @endif

                            </div>

                            <div class="form-check">


                                {!! Form::checkbox('published', 1, isset($row) ? ($row->published): 1, ['class' => 'form-check-input']) !!}

                                {!! Form::label('published', 'Публиковать', ['class' => 'form-check-label']) !!}

                                @if ($errors->has('published'))
                                    <p class="text-danger">{{ $errors->first('published') }}</p>
                                @endif

                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                {{ isset($row) ? 'редактировать' : 'добавить' }}
                            </button>
                            <a class="btn btn-default float-sm-right" href="{{ route('admin.manufacturers.index') }}">
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
                    let title = this.value;
                    let request = $.ajax({
                        url: '{!! route('admin.ajax') !!}',
                        method: "POST",
                        data: {
                            action: "get_manufacturer_slug",
                            title: title
                        },
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        dataType: "json"
                    });
                    console.log(request);
                    request.done(function (data) {
                        if (data.slug != null && data.slug !== '') {
                            $("#slug").val(data.slug);
                        }
                        console.log(data.slug);
                    });
                }
                console.log(this.value);
            });
        });
    </script>

@endsection
