<!DOCTYPE html>
<html lang="ru-ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Админ панель | @yield('title')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Font Awesome -->
    {!! Html::style('/plugins/fontawesome-free/css/all.min.css') !!}

    {!! Html::style('/plugins/sweetalert2/sweetalert2.min.css') !!}

    <!-- Theme style -->
    {!! Html::style('/dist/css/adminlte.min.css') !!}

    {!! Html::style('/plugins/toastr/toastr.min.css') !!}

    {!! Html::style('/plugins/flag-icon-css/css/flag-icon.min.css') !!}

    @yield('css')

    <script type="text/javascript">
        let SITE_URL = "{{ url('/') }}";
    </script>

</head>
<body class="hold-transition sidebar-mini">

<!-- Site wrapper -->
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" title="развернуть"
                   href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">

            <!-- Notifications Dropdown Menu -->
            <li class="nav-item">
                <a class="nav-link" title="выйти" href="{{ route('logout') }}"
                   role="button">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('admin.dashboard.index') }}" class="brand-link">
            <img src="{{ url('../images/logo.svg') }}" alt="АСТ" class="brand-image  elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">АСТ</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="info">
                    <a href="{{ route('admin.users.edit', ['id' => Auth::user()->id ]) }}"
                       class="d-block">{{ Auth::user()->login }} @if(!empty(Auth::user()->name))
                            ({{ Auth::user()->name }})
                        @endif</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="true">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->

                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard.index') }}"
                           class="nav-link{{ Request::is('cp') ? ' active' : '' }}"
                           title="Главная">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Главная</p>
                        </a>
                    </li>

                    <li class="nav-item{{ Request::is('cp/content*') ? ' menu-open' : '' }}">
                        <a href="#" class="nav-link{{ Request::is('cp/content*') ? ' active' : '' }}">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                                Контент
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.menu.index') }}"
                                   class="nav-link{{ Request::is('cp/content/manage-menus*') ? ' active' : '' }}"
                                   title="Меню">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Меню</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.pages.index') }}"
                                   class="nav-link{{ Request::is('cp/content/pages*') ? ' active' : '' }}"
                                   title="Страницы и разделы">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Страницы и разделы</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.news.index') }}"
                                   class="nav-link{{ Request::is('cp/content/news*') ? ' active' : '' }}"
                                   title="Новости">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Новости</p>
                                </a>
                            </li>

                        </ul>
                    </li>

                    @if(PermissionsHelper::has_permission('admin|moderator'))

                    <li class="nav-item{{ Request::is('cp/goods*') ? ' active menu-open' : '' }}">
                        <a href="#" class="nav-link{{ Request::is('cp/goods*') ? ' active' : '' }}">
                            <i class="nav-icon fas fa-list-ul"></i>
                            <p>
                                Продукция
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.catalog.index') }}"
                                   class="nav-link{{ Request::is('cp/goods/catalog*') ? ' active' : '' }}"
                                   title="Каталог">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Каталог</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.manufacturers.index') }}"
                                   class="nav-link{{ Request::is('cp/goods/manufacturers*') ? ' active' : '' }}"
                                   title="Производители">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Производители</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.products.index') }}"
                                   class="nav-link{{ Request::is('cp/goods/products*') ? ' active' : '' }}"
                                   title="Продукция">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Продукция</p>
                                </a>
                            </li>

                        </ul>
                    </li>

                    @endif

                    @if(PermissionsHelper::has_permission('admin|moderator'))

                        <li class="nav-item{{ Request::is('cp/seo*') ? ' active menu-open' : '' }}">
                            <a href="#" class="nav-link{{ Request::is('cp/seo*') ? ' active' : '' }}">
                                <i class="nav-icon fas fa-globe"></i>
                                <p>
                                    Seo
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.seo.index') }}"
                                       class="nav-link{{ Request::is('cp/seo') ? ' active' : '' }}"
                                       title="Seo">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Seo</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin.sitemap.index') }}"
                                       class="nav-link{{ Request::is('cp/seo/sitemap*') ? ' active' : '' }}"
                                       title="Карта сайта">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Карта сайта</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin.robots.edit') }}"
                                       class="nav-link{{ Request::is('cp/seo/robots*') ? ' active' : '' }}"
                                       title="Robots.txt">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Robots.txt</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin.redirect.index') }}"
                                       class="nav-link{{ Request::is('cp/seo/redirect*') ? ' active' : '' }}"
                                       title="Редирект">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Редирект</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                    @endif

                    <li class="nav-item{{ Request::is('cp/communication*') ? ' active menu-open' : '' }}">
                        <a href="#" class="nav-link{{ Request::is('cp/communication*') ? ' active' : '' }}">
                            <i class="nav-icon fas fa-comment"></i>
                            <p>
                                Обратная связь
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.feedback.index') }}"
                                   class="nav-link{{ Request::is('cp/communication/feedback*') ? ' active' : '' }}"
                                   title="Сообщения с сайта">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Сообщения с сайта</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.complaints.index') }}"
                                   class="nav-link{{ Request::is('cp/communication/complaints*') ? ' active' : '' }}"
                                   title="Претензии">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Претензии</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.invites.index') }}"
                                   class="nav-link{{ Request::is('cp/communication/invites*') ? ' active' : '' }}"
                                   title="Приглашение на тендер">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Приглашение на тендер</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.requests.index') }}"
                                   class="nav-link{{ Request::is('cp/communication/requests*') ? ' active' : '' }}"
                                   title="Запрос номенклатуры">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Запрос номенклатуры</p>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.orders.index') }}"
                           class="nav-link{{ Request::is('cp/orders*') ? ' active' : '' }}"
                           title="Заказы">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>Заказы</p>
                        </a>
                    </li>

                    @if(PermissionsHelper::has_permission('admin'))

                        <li class="nav-item">
                            <a href="{{ route('admin.customers.index') }}"
                               class="nav-link{{ Request::is('cp/customers*') ? ' active' : '' }}"
                               title="Пользователи">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Пользователи</p>
                            </a>
                        </li>

                    @endif

                    @if(PermissionsHelper::has_permission('admin'))

                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}"
                               class="nav-link{{ Request::is('cp/users*') ? ' active' : '' }}"
                               title="Администраторы">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Администраторы</p>
                            </a>
                        </li>

                    @endif

                    @if(PermissionsHelper::has_permission('admin'))

                        <li class="nav-item">
                            <a href="{{ route('admin.settings.index') }}"
                               class="nav-link{{ Request::is('cp/settings*') ? ' active' : '' }}"
                               title="Настройки">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>Настройки</p>
                            </a>
                        </li>

                    @endif

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ $title }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">

                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Админ панель</a></li>

                            @foreach($breadcrumbs ?? [] as $breadcrumb)
                                <li class="breadcrumb-item"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a></li>
                            @endforeach

                            <li class="breadcrumb-item active">{{ $title }}</li>
                        </ol>
                    </div>
                </div>

                @include('notifications')

            </div><!-- /.container-fluid -->
        </section>

        @yield('content')

    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b></b>
        </div>
        <strong>&copy; {{ date('Y') }} АСТ Компонентс</strong>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
{!! Html::script('/plugins/jquery/jquery.min.js') !!}
<!-- Bootstrap 4 -->
{!! Html::script('/plugins/bootstrap/js/bootstrap.bundle.min.js') !!}

{!! Html::script('/plugins/sweetalert2/sweetalert2.min.js') !!}
{!! Html::script('/plugins/toastr/toastr.min.js') !!}

<!-- AdminLTE App -->
{!! Html::script('/dist/js/adminlte.min.js') !!}

@yield('js')

</body>
</html>
