<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="format-detection" content="telephone=no">
    <link rel="icon" type="image/png" href="{{ url('/favicon/favicon-96x96.png') }}" sizes="96x96">
    <link rel="icon" type="image/svg+xml" href="{{ url('/favicon/favicon.svg') }}">
    <link rel="shortcut icon" href="{{ url('/favicon/favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{  url('/favicon/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ url('/favicon/site.webmanifest') }}">
    <meta name="apple-mobile-web-app-title" content="АСТ Компонентс">
    <meta property="og:site_name" content="astc.ru">
    <meta property="og:title" content="@yield('title')">
    <meta property="og:description" content="@yield('description')">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ url('/images/logo.jpg') }}">
    <meta property="og:image:alt" content="@yield('title') АСТ Компонентс">
    <meta property="og:url" content="@yield('seo_url_canonical')">
    <meta property="og:locale" content="ru_RU">
    <link rel="preload" href="{{ url('/fonts/PT-Root-UI-Regular.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ url('/fonts/PT-Root-UI-Medium.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ url('/fonts/PT-Root-UI-Bold.woff2') }}" as="font" type="font/woff2" crossorigin>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! Html::style('/css/styles.min.css?v=1') !!}

    @yield('css')

    {!! Html::script('/scripts/script.min.js?v=1') !!}

</head>

<body>
<header class="header js-header">
    <div class="header__wrap">
        <div class="header__top js-header-menu">
            <nav class="header__nav">
                <ul>
                    <li><a href="./how-to-order.html" class="header__nav-item">Как сделать заказ</a></li>
                    <li><a href="./conditions.html" class="header__nav-item">Доставка и оплата</a></li>
                    <li><a href="./manufacturers.html" class="header__nav-item">Производители</a></li>
                    <li class="header__submenu js-header-submenu">
                        <button type="button" class="header__nav-item js-header-submenu-btn">
                            О компании
                            <svg aria-hidden="true" class="orange">
                                <use xlink:href="images/sprite.svg#chevron-down"></use>
                            </svg>
                        </button>
                        <div class="header__submenu-nav">
                            <ul>

                                <li><a href="./about.html">О нас</a></li>
                                <li><a href="./details.html">Реквизиты</a></li>
                                <li><a href="./invite.html">Пригласить на тендер</a></li>
                                <li><a href="./request.html">Запрос номенклатуры</a></li>
                                <li><a href="./career.html">Карьера</a></li>

                            </ul>
                        </div>
                    </li>
                    <li><a href="./news.html" class="header__nav-item">Новости</a></li>
                    <li><a href="./contacts.html" class="header__nav-item">Контакты</a></li>
                    <li><a href="./converters.html" class="header__nav-item header__nav-item--converters">Конвертеры</a>
                    </li>
                </ul>
            </nav>
            <div class="header__contacts">
                <div class="header__contacts-item">
                    <div class="header__contacts-title">
                        <svg aria-hidden="true" class="light-blue">
                            <use xlink:href="images/sprite.svg#mail"></use>
                        </svg>
                        <span>Электронная почта</span>
                    </div>
                    <a href="mailto:info@astc.ru" class="header__contact">Справка: info@astc.ru</a>
                    <a href="mailto:sales@astc.ru" class="header__contact">Заказы: sales@astc.ru</a>
                </div>
                <div class="header__contacts-item">
                    <div class="header__contacts-title">
                        <svg aria-hidden="true" class="light-blue">
                            <use xlink:href="images/sprite.svg#phone"></use>
                        </svg>
                        <span>Телефон</span>
                    </div>
                    <a href="tel:+74951234514" class="header__contact">8 (495) 123-45-14</a>
                    <a href="tel:+74959814114" class="header__contact">8 (495) 981-41-14</a>
                </div>
            </div>
        </div>
        <div class="header__bottom">
            <div class="header__logo-wrap">

                <a href="./" class="header__logo-link">
                    <span class="sr-only">Перейти на главную страницу АСТ Компонентс</span>
                </a>
            </div>
            <div class="header__catalog js-header-catalog">
                <button type="button" class="header__catalog-btn btn btn--primary js-header-catalog-btn">
                    <svg aria-hidden="true" class="white">
                        <use xlink:href="images/sprite.svg#catalog"></use>
                    </svg>
                    <span>Каталог</span>
                </button>
                <div class="header__catalog-menu js-header-catalog-menu">
                    <div class="header__category">
                        <ul class="header__category-list">
                            <li class="header__category-item js-header-category-item">
                                    <span>
                                        <a href="./catalog.html">Микроконтроллеры</a>
                                        <sup class="header__item-count">100 000</sup>
                                    </span>
                                <svg aria-hidden="true" class="orange">
                                    <use xlink:href="images/sprite.svg#chevron-right"></use>
                                </svg>
                            </li>
                            <li class="header__category-item js-header-category-item">
                                    <span>
                                        <a href="./catalog.html">Аналоговые компоненты</a>
                                        <sup class="header__item-count">2 000</sup>
                                    </span>
                                <svg aria-hidden="true" class="orange">
                                    <use xlink:href="images/sprite.svg#chevron-right"></use>
                                </svg>
                            </li>
                            <li class="header__category-item js-header-category-item">
                                    <span>
                                        <a href="./catalog.html">Схемы памяти (EEPROM, FLASH, SRAM)</a>
                                        <sup class="header__item-count">2 000</sup>
                                    </span>
                                <svg aria-hidden="true" class="orange">
                                    <use xlink:href="images/sprite.svg#chevron-right"></use>
                                </svg>
                            </li>
                            <li class="header__category-item js-header-category-item">
                                    <span>
                                        <a href="./catalog.html">Схемы программируемой логики (CPLD)</a>
                                        <sup class="header__item-count">25 700</sup>
                                    </span>
                                <svg aria-hidden="true" class="orange">
                                    <use xlink:href="images/sprite.svg#chevron-right"></use>
                                </svg>
                            </li>
                            <li class="header__category-item js-header-category-item">
                                    <span>
                                        <a href="./catalog.html">Приемо-передатчики проводных линий (трансиверы RS485, CAN, UART)</a>
                                        <sup class="header__item-count">15 700</sup>
                                    </span>
                                <svg aria-hidden="true" class="orange">
                                    <use xlink:href="images/sprite.svg#chevron-right"></use>
                                </svg>
                            </li>
                            <li class="header__category-item js-header-category-item">
                                    <span>
                                        <a href="./catalog.html">Дискретные компоненты</a>
                                        <sup class="header__item-count">15 700</sup>
                                    </span>
                                <svg aria-hidden="true" class="orange">
                                    <use xlink:href="images/sprite.svg#chevron-right"></use>
                                </svg>
                            </li>
                            <li class="header__category-item js-header-category-item">
                                    <span>
                                        <a href="./catalog.html">Оптоэлектронные компоненты</a>
                                        <sup class="header__item-count">15 700</sup>
                                    </span>
                                <svg aria-hidden="true" class="orange">
                                    <use xlink:href="images/sprite.svg#chevron-right"></use>
                                </svg>
                            </li>
                        </ul>
                    </div>
                    <div class="header__subcategory">
                        <ul class="header__subcategory-list">
                            <li class="header__subcategory-item">
                                    <span>
                                        <a href="./catalog.html">Аттенюаторы</a>
                                        <sup class="header__item-count">10 000</sup>
                                    </span>
                                <ul>
                                    <li>
                                        <a href="./catalog.html">Номенклатура 1</a>
                                        <sup class="header__item-count">10 000</sup>
                                    </li>
                                    <li>
                                        <a href="./catalog.html">Номенклатура 2</a>
                                        <sup class="header__item-count">10 000</sup>
                                    </li>
                                    <li>
                                        <a href="./catalog.html">Номенклатура 3</a>
                                        <sup class="header__item-count">10 000</sup>
                                    </li>
                                </ul>
                            </li>
                            <li class="header__subcategory-item">
                                    <span>
                                        <a href="./catalog.html">ВЧ детекторы</a>
                                        <sup class="header__item-count">10 000</sup>
                                    </span>
                                <ul>
                                    <li>
                                        <a href="./catalog.html">Номенклатура 1</a>
                                        <sup class="header__item-count">10 000</sup>
                                    </li>
                                    <li>
                                        <a href="./catalog.html">Номенклатура 2</a>
                                        <sup class="header__item-count">10 000</sup>
                                    </li>
                                </ul>
                            </li>
                            <li class="header__subcategory-item">
                                    <span>
                                        <a href="./catalog.html">Видеоусилители</a>
                                        <sup class="header__item-count">10 000</sup>
                                    </span>
                                <ul>
                                    <li>
                                        <a href="./catalog.html">Номенклатура 1</a>
                                        <sup class="header__item-count">10 000</sup>
                                    </li>
                                    <li>
                                        <a href="./catalog.html">Номенклатура 2</a>
                                        <sup class="header__item-count">10 000</sup>
                                    </li>
                                </ul>
                            </li>
                            <li class="header__subcategory-item">
                                    <span>
                                        <a href="./catalog.html">Драйверы Full и Half-Bridge</a>
                                        <sup class="header__item-count">10 000</sup>
                                    </span>
                            </li>
                            <li class="header__subcategory-item">
                                    <span>
                                        <a href="./catalog.html">Контроллеры Capacitive Touch, Proximity</a>
                                        <sup class="header__item-count">10 000</sup>
                                    </span>
                                <ul>
                                    <li>
                                        <a href="./catalog.html">Номенклатура 1</a>
                                        <sup class="header__item-count">10 000</sup>
                                    </li>
                                    <li>
                                        <a href="./catalog.html">Номенклатура 2</a>
                                        <sup class="header__item-count">10 000</sup>
                                    </li>
                                    <li>
                                        <a href="./catalog.html">Номенклатура 3</a>
                                        <sup class="header__item-count">10 000</sup>
                                    </li>
                                </ul>
                            </li>
                            <li class="header__subcategory-item">
                                    <span>
                                        <a href="./catalog.html">Логические - FIFO память</a>
                                        <sup class="header__item-count">10 000</sup>
                                    </span>
                                <ul>
                                    <li>
                                        <a href="./catalog.html">Номенклатура 1</a>
                                        <sup class="header__item-count">10 000</sup>
                                    </li>
                                    <li>
                                        <a href="./catalog.html">Номенклатура 2</a>
                                        <sup class="header__item-count">10 000</sup>
                                    </li>
                                    <li>
                                        <a href="./catalog.html">Номенклатура 3</a>
                                        <sup class="header__item-count">10 000</sup>
                                    </li>
                                    <li>
                                        <a href="./catalog.html">Номенклатура 4</a>
                                        <sup class="header__item-count">10 000</sup>
                                    </li>
                                    <li>
                                        <a href="./catalog.html">Номенклатура 5</a>
                                        <sup class="header__item-count">10 000</sup>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="header__search js-header-search">
                    <div class="header__search-control form-control">
                        <label for="main-search" class="sr-only">Поиск электронных компонентов на сайте</label>
                        <input type="text" id="main-search" placeholder="Поиск электронных компонентов на сайте"
                               class="js-header-search-input">
                        <button type="button" class="header__search-btn btn btn--icon">
                            <svg aria-hidden="true" class="light-blue">
                                <use xlink:href="images/sprite.svg#search"></use>
                            </svg>
                            <span class="sr-only">Найти</span>
                        </button>
                    </div>
                    <div class="header__search-hint">
                        <ul>
                            <li><a href="./product-details.html">PIC16F628A-I/P, Микроконтроллер 8-Бит, PIC, 20МГц,
                                    3.5КБ (2Кx14) Flash, 16 I/O [DIP-18]</a></li>
                            <li><a href="./product-details.html">ATTINY13A-SSU, Микроконтроллер 8-Бит, picoPower, AVR,
                                    20МГц, 1КБ Flash [SO-8, 0.150".]</a></li>
                            <li><a href="./product-details.html">STM32F103C8T6, Микроконтроллер 32-Бит, Cortex-M3,
                                    72МГц, 64КБ Flash, USB, CAN [LQFP-48.]</a></li>
                            <li><a href="./product-details.html">STM32F405RGT6, Микроконтроллер 32-Бит, Cortex-M4 + FPU,
                                    168МГц, 1МБ Flash, USB OTG HS/FS [LQFP-64.]</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="header__btns">
                <div class="header__cart-btn">
                    <a href="./cart-auth.html" class="btn">
                        <svg aria-hidden="true" class="orange">
                            <use xlink:href="images/sprite.svg#cart"></use>
                        </svg>
                        <span>Корзина</span>
                    </a>
                    <span class="header__cart-count">10</span>
                </div>

                <button type="button" class="header__login-btn btn" data-modal-trigger="login">
                    <svg aria-hidden="true" class="orange">
                        <use xlink:href="images/sprite.svg#user"></use>
                    </svg>
                    <span>Вход/Регистрация</span>
                </button>


                <a href="./converters.html" class="header__converters-btn btn btn--link">
                    <svg aria-hidden="true" class="orange">
                        <use xlink:href="images/sprite.svg#calculation"></use>
                    </svg>
                    <span>Конвертеры</span>
                </a>
                <button type="button" class="header__menu-btn btn js-header-menu-btn">
                    <span class="header__burger-icon"></span>
                    <span>Меню</span>
                </button>
            </div>
        </div>
    </div>
</header>
<main>
    <div class="page-header container-lg">
        <div class="page-header__wrap">
            <ul class="breadcrumbs">

                <li><a href="./" class="breadcrumbs-item">Главная</a></li>


                <li><span class="breadcrumbs-item">О нас</span></li>

            </ul>
            <h1>О компании АСТ&#160;Компонентс</h1>

        </div>
    </div>

    <div class="about container-md">
        <div class="about__logo">
            <img src="./images/logo.svg" alt="" aria-hidden="true">
        </div>
        <div class="about__info">
            <p class="about__text">АСТ Компонентс начала работать в то время, когда купить микросхему на Митинском рынке
                было проще, чем у официальных поставщиков. С&nbsp;первых дней для нас было важно одно — чтобы клиент
                всегда получал нужные и надёжные электронные компоненты.</p>
            <span class="about__title">Поэтому мы:</span>
            <ul class="about__list">
                <li>Думаем в первую очередь о задачах заказчика</li>
                <li>Используем опыт и связи как на российских, так и на зарубежных рынках</li>
                <li>Выбираем только <a href="./manufacturers.html">проверенных партнёров</a></li>
            </ul>
            <div class="about__title">
                <h2>На чём держится наша работа</h2>
            </div>
            <ul class="about__principle-list">
                <li>
                    <article class="principle">
                        <div class="principle__indicators">
                            <svg aria-hidden="true">
                                <use xlink:href="images/sprite.svg#breadcrumb-separator"></use>
                            </svg>
                            <svg aria-hidden="true">
                                <use xlink:href="images/sprite.svg#breadcrumb-separator"></use>
                            </svg>
                            <svg aria-hidden="true">
                                <use xlink:href="images/sprite.svg#breadcrumb-separator"></use>
                            </svg>
                            <svg aria-hidden="true">
                                <use xlink:href="images/sprite.svg#breadcrumb-separator"></use>
                            </svg>
                        </div>
                        <div>
                            <div class="principle__title">
                                <h3>Надежность</h3>
                            </div>
                            <p class="principle__description">Фиксированные договорные условия, соблюдение обязательств,
                                прозрачные цены</p>
                        </div>
                    </article>
                </li>
                <li>
                    <article class="principle">
                        <div class="principle__indicators">
                            <svg aria-hidden="true">
                                <use xlink:href="images/sprite.svg#breadcrumb-separator"></use>
                            </svg>
                            <svg aria-hidden="true">
                                <use xlink:href="images/sprite.svg#breadcrumb-separator"></use>
                            </svg>
                            <svg aria-hidden="true">
                                <use xlink:href="images/sprite.svg#breadcrumb-separator"></use>
                            </svg>
                            <svg aria-hidden="true">
                                <use xlink:href="images/sprite.svg#breadcrumb-separator"></use>
                            </svg>
                        </div>
                        <div>
                            <div class="principle__title">
                                <h3>Профессионализм</h3>
                            </div>
                            <p class="principle__description">Квалифицированная команда, широкая сеть поставщиков,
                                техподдержка</p>
                        </div>
                    </article>
                </li>
                <li>
                    <article class="principle">
                        <div class="principle__indicators">
                            <svg aria-hidden="true">
                                <use xlink:href="images/sprite.svg#breadcrumb-separator"></use>
                            </svg>
                            <svg aria-hidden="true">
                                <use xlink:href="images/sprite.svg#breadcrumb-separator"></use>
                            </svg>
                            <svg aria-hidden="true">
                                <use xlink:href="images/sprite.svg#breadcrumb-separator"></use>
                            </svg>
                            <svg aria-hidden="true">
                                <use xlink:href="images/sprite.svg#breadcrumb-separator"></use>
                            </svg>
                        </div>
                        <div>
                            <div class="principle__title">
                                <h3>Взаимоуважение</h3>
                            </div>
                            <p class="principle__description">Долгосрочные партнёрства и честные условия</p>
                        </div>
                    </article>
                </li>
                <li>
                    <article class="principle">
                        <div class="principle__indicators">
                            <svg aria-hidden="true">
                                <use xlink:href="images/sprite.svg#breadcrumb-separator"></use>
                            </svg>
                            <svg aria-hidden="true">
                                <use xlink:href="images/sprite.svg#breadcrumb-separator"></use>
                            </svg>
                            <svg aria-hidden="true">
                                <use xlink:href="images/sprite.svg#breadcrumb-separator"></use>
                            </svg>
                            <svg aria-hidden="true">
                                <use xlink:href="images/sprite.svg#breadcrumb-separator"></use>
                            </svg>
                        </div>
                        <div>
                            <div class="principle__title">
                                <h3>Скорость и&nbsp;результат</h3>
                            </div>
                            <p class="principle__description">Быстрая реакция на запросы и комплексная комплектация </p>
                        </div>
                    </article>
                </li>
            </ul>
            <p class="about__text">Мы уверены, что наша деятельность способствует развитию технологий, укреплению
                позиций клиентов на рынке и построению долгосрочных партнёрских отношений.</p>
            <div class="about__btn-wrap">
                <a href="./images/logo.svg" download="logo.svg" class="btn btn--tertiary">
                    <svg aria-hidden="true">
                        <use xlink:href="images/sprite.svg#download"></use>
                    </svg>
                    <span>Договор поставки</span>
                </a>
                <span class="about__discuss">Хотите обсудить сотрудничество?<br><a href="./contacts.html">Свяжитесь с нами</a> любым удобным способом</span>
            </div>
        </div>
    </div>
</main>
<div class="mobile-menu">
    <div class="mobile-menu__wrap">

        <button type="button" class="mobile-menu__btn" data-modal-trigger="login">
            <svg aria-hidden="true" class="orange">
                <use xlink:href="images/sprite.svg#user"></use>
            </svg>
            <span>Вход</span>
        </button>


        <button type="button" class="mobile-menu__btn js-mobile-menu-search-btn">
            <svg aria-hidden="true" class="orange">
                <use xlink:href="images/sprite.svg#search"></use>
            </svg>
            <span>Поиск</span>
        </button>
        <button type="button" class="mobile-menu__btn js-mobile-menu-catalog-btn">
            <svg aria-hidden="true" class="orange">
                <use xlink:href="images/sprite.svg#catalog"></use>
            </svg>
            <span>Каталог</span>
        </button>
        <a href="./cart-auth.html" class="mobile-menu__btn">
            <svg aria-hidden="true" class="orange">
                <use xlink:href="images/sprite.svg#cart"></use>
            </svg>
            <span>Корзина</span>
            <span class="mobile-menu__count">10</span>
        </a>
        <button type="button" class="mobile-menu__btn">
            <svg aria-hidden="true" class="orange">
                <use xlink:href="images/sprite.svg#chat"></use>
            </svg>
            <span>Чат</span>
        </button>
    </div>
</div>
<div class="mobile-search js-mobile-search">
    <button type="button" class="mobile-search__close-btn btn btn--icon btn--sm js-close-search-btn">
        <svg aria-hidden="true" class="orange">
            <use xlink:href="./images/sprite.svg#close"/>
        </svg>
    </button>
    <div class="mobile-search__title">
        <h2>Поиск электронных компонентов на&nbsp;сайте</h2>
    </div>
    <div class="mobile-search__control form-input">
        <label for="mobile-search" class="sr-only">Поиск</label>
        <input type="text" id="mobile-search" placeholder="Поиск" class="js-mobile-search-input">
        <button type="button" class="mobile-search__search-btn btn btn--icon">
            <svg aria-hidden="true" class="light-blue">
                <use xlink:href="images/sprite.svg#search"></use>
            </svg>
            <span class="sr-only">Найти</span>
        </button>
    </div>
    <ul class="mobile-search__hint-list js-mobile-search-hint">
        <li><a href="./product-details.html">PIC16F628A-I/P, Микроконтроллер 8-Бит, PIC, 20МГц, 3.5КБ (2Кx14) Flash, 16
                I/O [DIP-18]</a></li>
        <li><a href="./product-details.html">ATTINY13A-SSU, Микроконтроллер 8-Бит, picoPower, AVR, 20МГц, 1КБ Flash
                [SO-8, 0.150".]</a></li>
        <li><a href="./product-details.html">STM32F103C8T6, Микроконтроллер 32-Бит, Cortex-M3, 72МГц, 64КБ Flash, USB,
                CAN [LQFP-48.]</a></li>
        <li><a href="./product-details.html">STM32F405RGT6, Микроконтроллер 32-Бит, Cortex-M4 + FPU, 168МГц, 1МБ Flash,
                USB OTG HS/FS [LQFP-64.]</a></li>
        <li><a href="./product-details.html">ATmega328P-AU, Микроконтроллер 8-Бит, picoPower, AVR, 20МГц, 32КБ Flash
                [TQFP-32]</a></li>
        <li><a href="./product-details.html">PIC16F628A-I/P, Микроконтроллер 8-Бит, PIC, 20МГц, 3.5КБ (2Кx14) Flash, 16
                I/O [DIP-18]</a></li>
        <li><a href="./product-details.html">ATTINY13A-SSU, Микроконтроллер 8-Бит, picoPower, AVR, 20МГц, 1КБ Flash
                [SO-8, 0.150".]</a></li>
        <li><a href="./product-details.html">STM32F103C8T6, Микроконтроллер 32-Бит, Cortex-M3, 72МГц, 64КБ Flash, USB,
                CAN [LQFP-48.]</a></li>
        <li><a href="./product-details.html">STM32F405RGT6, Микроконтроллер 32-Бит, Cortex-M4 + FPU, 168МГц, 1МБ Flash,
                USB OTG HS/FS [LQFP-64.]</a></li>
        <li><a href="./product-details.html">ATmega328P-AU, Микроконтроллер 8-Бит, picoPower, AVR, 20МГц, 32КБ Flash
                [TQFP-32]</a></li>

    </ul>
</div>
<div class="mobile-catalog js-mobile-catalog">
    <button type="button" class="mobile-catalog__close-btn btn btn--icon btn--sm js-close-catalog-btn">
        <svg aria-hidden="true" class="orange">
            <use xlink:href="./images/sprite.svg#close"/>
        </svg>
    </button>
    <div class="mobile-catalog__title">
        <h2>Каталог</h2>
    </div>
    <a href="./catalog.html" class="mobile-catalog__all-btn btn btn--secondary">
        <span>Смотреть все</span>
        <svg aria-hidden="true" class="orange">
            <use xlink:href="images/sprite.svg#arrow-right-circle"></use>
        </svg>
    </a>
    <div class="mobile-catalog__accordions accordions">
        <div class="accordion__item">
            <button class="accordion__btn js-accordion-btn" aria-expanded="false">
                    <span>
                        <span class="accordion__title">Микроконтроллеры</span>
                        <sup class="mobile-catalog__item-count">100 000</sup>
                    </span>
                <svg aria-hidden="true" class="orange">
                    <use xlink:href="images/sprite.svg#chevron-down"></use>
                </svg>
            </button>
            <div class="accordion__content">
                <div class="mobile-catalog__list">
                        <span class="mobile-catalog__category">
                            <a href="./catalog.html">Смотреть все</a>
                            <sup class="mobile-catalog__item-count">100 000</sup>
                        </span>
                    <span class="mobile-catalog__category">
                            <a href="./catalog.html">Аттенюаторы</a>
                            <sup class="mobile-catalog__item-count">10 000</sup>
                        </span>
                    <span class="mobile-catalog__subcategory">
                            <a href="./catalog.html">Номенклатура 1</a>
                            <sup class="mobile-catalog__item-count">10 000</sup>
                        </span>
                    <span class="mobile-catalog__subcategory">
                            <a href="./catalog.html">Номенклатура 2</a>
                            <sup class="mobile-catalog__item-count">10 000</sup>
                        </span>
                    <span class="mobile-catalog__subcategory">
                            <a href="./catalog.html">Номенклатура 3</a>
                            <sup class="mobile-catalog__item-count">10 000</sup>
                        </span>
                    <span class="mobile-catalog__category">
                            <a href="./catalog.html">ВЧ детекторы</a>
                            <sup class="mobile-catalog__item-count">10 000</sup>
                        </span>
                    <span class="mobile-catalog__subcategory">
                            <a href="./catalog.html">Номенклатура 1</a>
                            <sup class="mobile-catalog__item-count">10 000</sup>
                        </span>
                    <span class="mobile-catalog__subcategory">
                            <a href="./catalog.html">Номенклатура 2</a>
                            <sup class="mobile-catalog__item-count">10 000</sup>
                        </span>
                    <span class="mobile-catalog__category">
                            <a href="./catalog.html">Видеоусилители</a>
                            <sup class="mobile-catalog__item-count">10 000</sup>
                        </span>
                    <span class="mobile-catalog__subcategory">
                            <a href="./catalog.html">Номенклатура 1</a>
                            <sup class="mobile-catalog__item-count">10 000</sup>
                        </span>
                    <span class="mobile-catalog__subcategory">
                            <a href="./catalog.html">Номенклатура 2</a>
                            <sup class="mobile-catalog__item-count">10 000</sup>
                        </span>
                    <span class="mobile-catalog__category">
                            <a href="./catalog.html">Драйверы Full и Half-Bridge</a>
                            <sup class="mobile-catalog__item-count">10 000</sup>
                        </span>
                    <span class="mobile-catalog__category">
                            <a href="./catalog.html">Контроллеры Capacitive Touch, Proximity</a>
                            <sup class="mobile-catalog__item-count">10 000</sup>
                        </span>
                    <span class="mobile-catalog__subcategory">
                            <a href="./catalog.html">Номенклатура 1</a>
                            <sup class="mobile-catalog__item-count">10 000</sup>
                        </span>
                    <span class="mobile-catalog__subcategory">
                            <a href="./catalog.html">Номенклатура 2</a>
                            <sup class="mobile-catalog__item-count">10 000</sup>
                        </span>
                    <span class="mobile-catalog__subcategory">
                            <a href="./catalog.html">Номенклатура 3</a>
                            <sup class="mobile-catalog__item-count">10 000</sup>
                        </span>
                </div>
            </div>
        </div>
        <div class="accordion__item">
            <button class="accordion__btn js-accordion-btn" aria-expanded="false">
                    <span>
                        <span class="accordion__title">Аналоговые компоненты</span>
                        <sup class="mobile-catalog__item-count">2 000</sup>
                    </span>
                <svg aria-hidden="true" class="orange">
                    <use xlink:href="images/sprite.svg#chevron-down"></use>
                </svg>
            </button>
            <div class="accordion__content">
                <div class="mobile-catalog__list">
                        <span class="mobile-catalog__category">
                            <a href="./catalog.html">Смотреть все</a>
                            <sup class="mobile-catalog__item-count">100 000</sup>
                        </span>
                    <span class="mobile-catalog__category">
                            <a href="./catalog.html">Аттенюаторы</a>
                            <sup class="mobile-catalog__item-count">10 000</sup>
                        </span>
                    <span class="mobile-catalog__subcategory">
                            <a href="./catalog.html">Номенклатура 1</a>
                            <sup class="mobile-catalog__item-count">10 000</sup>
                        </span>
                    <span class="mobile-catalog__subcategory">
                            <a href="./catalog.html">Номенклатура 2</a>
                            <sup class="mobile-catalog__item-count">10 000</sup>
                        </span>
                    <span class="mobile-catalog__subcategory">
                            <a href="./catalog.html">Номенклатура 3</a>
                            <sup class="mobile-catalog__item-count">10 000</sup>
                        </span>
                    <span class="mobile-catalog__category">
                            <a href="./catalog.html">ВЧ детекторы</a>
                            <sup class="mobile-catalog__item-count">10 000</sup>
                        </span>
                    <span class="mobile-catalog__subcategory">
                            <a href="./catalog.html">Номенклатура 1</a>
                            <sup class="mobile-catalog__item-count">10 000</sup>
                        </span>
                    <span class="mobile-catalog__subcategory">
                            <a href="./catalog.html">Номенклатура 2</a>
                            <sup class="mobile-catalog__item-count">10 000</sup>
                        </span>
                </div>
            </div>
        </div>
        <div class="accordion__item">
            <button class="accordion__btn js-accordion-btn" aria-expanded="false">
                    <span>
                        <span class="accordion__title">Схемы памяти (EEPROM, FLASH, SRAM)</span>
                        <sup class="mobile-catalog__item-count">2 000</sup>
                    </span>
                <svg aria-hidden="true" class="orange">
                    <use xlink:href="images/sprite.svg#chevron-down"></use>
                </svg>
            </button>
            <div class="accordion__content">
                <div class="mobile-catalog__list">
                        <span class="mobile-catalog__category">
                            <a href="./catalog.html">Смотреть все</a>
                            <sup class="mobile-catalog__item-count">100 000</sup>
                        </span>
                    <span class="mobile-catalog__category">
                            <a href="./catalog.html">Аттенюаторы</a>
                            <sup class="mobile-catalog__item-count">10 000</sup>
                        </span>
                    <span class="mobile-catalog__subcategory">
                            <a href="./catalog.html">Номенклатура 1</a>
                            <sup class="mobile-catalog__item-count">10 000</sup>
                        </span>
                    <span class="mobile-catalog__subcategory">
                            <a href="./catalog.html">Номенклатура 2</a>
                            <sup class="mobile-catalog__item-count">10 000</sup>
                        </span>
                    <span class="mobile-catalog__subcategory">
                            <a href="./catalog.html">Номенклатура 3</a>
                            <sup class="mobile-catalog__item-count">10 000</sup>
                        </span>
                </div>
            </div>
        </div>
        <div class="accordion__item">
            <button class="accordion__btn js-accordion-btn" aria-expanded="false">
                    <span>
                        <span class="accordion__title">Схемы программируемой логики (CPLD)</span>
                        <sup class="mobile-catalog__item-count">25 700</sup>
                    </span>
                <svg aria-hidden="true" class="orange">
                    <use xlink:href="images/sprite.svg#chevron-down"></use>
                </svg>
            </button>
            <div class="accordion__content">
                <div class="mobile-catalog__list">
                        <span class="mobile-catalog__category">
                            <a href="./catalog.html">Смотреть все</a>
                            <sup class="mobile-catalog__item-count">100 000</sup>
                        </span>
                    <span class="mobile-catalog__category">
                            <a href="./catalog.html">Аттенюаторы</a>
                            <sup class="mobile-catalog__item-count">10 000</sup>
                        </span>
                    <span class="mobile-catalog__subcategory">
                            <a href="./catalog.html">Номенклатура 1</a>
                            <sup class="mobile-catalog__item-count">10 000</sup>
                        </span>
                    <span class="mobile-catalog__subcategory">
                            <a href="./catalog.html">Номенклатура 2</a>
                            <sup class="mobile-catalog__item-count">10 000</sup>
                        </span>
                    <span class="mobile-catalog__subcategory">
                            <a href="./catalog.html">Номенклатура 3</a>
                            <sup class="mobile-catalog__item-count">10 000</sup>
                        </span>
                </div>
            </div>
        </div>
    </div>
</div>
<button type="button" class="chat-btn btn btn--tertiary btn--icon">
    <svg aria-hidden="true" class="white">
        <use xlink:href="images/sprite.svg#chat"></use>
    </svg>
    <span class="sr-only">Чат</span>
</button>
<footer class="footer container-lg">
    <div class="footer__wrap">
        <div class="section-title">
            <h2>АСТ Компонентс&nbsp; &#8212; &nbsp;надёжные поставки, долгосрочное партнёрство</h2>
        </div>
        <div class="footer__top">
            <div class="footer__logo-wrap">

                <a href="{{ url('/') }}" class="footer__logo-link">
                    <span class="sr-only">Перейти на главную страницу АСТ Компонентс</span>
                </a>
            </div>
            <div class="footer__main-links">
                <div class="footer__main-links-wrap">
                    <a href="./catalog.html" class="footer__catalog-btn btn btn--tertiary">
                        <span>Каталог</span>
                        <svg aria-hidden="true" class="white">
                            <use xlink:href="images/sprite.svg#arrow-right-circle"></use>
                        </svg>
                    </a>

                    @if(isset($menu['bottom-left']) and $menu['bottom-left'])
                        <ul class="footer__nav">
                            @foreach($menu['bottom-left'] as $item)
                                <li><a href="{{ $item['link'] }}" class="footer__nav-link">{{ $item['label'] }}</a></li>
                            @endforeach
                        </ul>
                    @endif

                </div>
            </div>
            <div class="footer__company-links">
                <div class="footer__company-links-wrap">
                    <div class="footer__title">
                        <h3>О компании</h3>
                    </div>

                    @if(isset($menu['bottom-right']) and $menu['bottom-right'])
                        <ul class="footer__nav">
                            @foreach($menu['bottom-right'] as $item)
                                <li><a href="{{ $item['link'] }}" class="footer__nav-link">{{ $item['label'] }}</a></li>
                            @endforeach
                        </ul>
                    @endif

                </div>
            </div>
            <div class="footer__contacts-list">
                <div class="footer__contacts-line">
                    <div>
                        <div class="footer__title">
                            <svg aria-hidden="true" class="orange">
                                <use xlink:href="images/sprite.svg#mail"></use>
                            </svg>
                            <h3>Электронная почта</h3>
                        </div>
                        <address class="footer__contact-item">
                            <div class="footer__contact">
                                <a href="mailto:info@astc.ru">info@astc.ru</a>
                                <span> — справка</span>
                            </div>
                            <div class="footer__contact">
                                <a href="mailto:info@astc.ru">sales@astc.ru</a>
                                <span> — заказы</span>
                            </div>
                        </address>
                    </div>
                    <div>
                        <div class="footer__title">
                            <svg aria-hidden="true" class="orange">
                                <use xlink:href="images/sprite.svg#phone"></use>
                            </svg>
                            <h3>Телефон</h3>
                        </div>
                        <address class="footer__contact-item">
                            <div class="footer__contact">
                                <a href="tel:{{ StringHelper::getPhoneTag(SettingsHelper::getInstance()->getValueForKey('PHONE')) }}">{{ SettingsHelper::getInstance()->getValueForKey('PHONE') }}</a>
                            </div>
                        </address>
                    </div>
                </div>
                <div>
                    <div class="footer__title">
                        <svg aria-hidden="true" class="orange">
                            <use xlink:href="images/sprite.svg#location"></use>
                        </svg>
                        <h3>Адрес</h3>
                    </div>
                    <address class="footer__contact-item">
                        <div class="footer__contact footer__contact-address">
                            <a href="{{ StringHelper::getPhoneTag(SettingsHelper::getInstance()->getValueForKey('MAP_ADRESS_LINK')) }}"
                               target="_blank"
                               rel="noopener noreferrer">{{ SettingsHelper::getInstance()->getValueForKey('REAL_ADDRESS') }}</a>
                        </div>
                    </address>
                </div>
            </div>
        </div>
        <div class="footer__bottom">
            <span class="footer__copyright">©{{ env('APP_NAME', 'АСТ Компонентс') }}, {{ date('Y') }}</span>
            <a href="./privacy-policy.html" class="footer__privacy-link">Политика конфиденциальности</a>
            <div class="footer__up-btn">
                <button type="button" class="btn js-up-btn">
                    <span>Наверх</span>
                    <svg aria-hidden="true" class="orange">
                        <use xlink:href="images/sprite.svg#arrow-top"></use>
                    </svg>
                </button>
            </div>
            <a href="https://julia-karavaeva.ru/" target="_blank" rel="noopener noreferrer" class="footer__author-link">
                Дизайн сайта
            </a>
        </div>
    </div>
</footer>
<div class="modal modal--login js-modal" data-modal-name="login">
    <div class="modal__wrap">
        <div class="modal__dialog js-modal-dialog" role="dialog" aria-modal="true">
            <button type="button" class="modal__close-btn btn btn--icon btn--sm js-modal-close">
                <span class="sr-only">Закрыть модальное окно</span>
                <svg aria-hidden="true">
                    <use xlink:href="images/sprite.svg#close"></use>
                </svg>
            </button>
            <div class="modal__content">
                <div class="modal__title">
                    <h2>Вход в личный кабинет</h2>
                </div>
                <form class="modal__form">
                    <div class="form-input">
                        <label for="login-phone">Номер телефона*</label>
                        <input type="tel" id="login-phone" placeholder='+7 900 000-00-00' required>
                    </div>
                    <div class="form-password">
                        <label for="login-password">Пароль*</label>
                        <button type="button" class="form-forgot-btn btn btn--link"
                                data-modal-trigger="password-recovery">Забыли пароль?
                        </button>
                        <input type="password" id="login-password" placeholder='*******' required>
                        <div class="form-display-btn">
                            <input type="checkbox" id="login-display-password">
                            <label for="login-display-password">Показать пароль</label>
                        </div>
                    </div>
                    <div class="modal__btns">
                        <button type="button" class="btn btn--primary">
                            <svg aria-hidden="true">
                                <use xlink:href="images/sprite.svg#login"></use>
                            </svg>
                            <span>Войти</span>
                        </button>
                        <button type="button" class="btn btn--secondary" data-modal-trigger="sign-up">
                            <svg aria-hidden="true">
                                <use xlink:href="images/sprite.svg#user-plus"></use>
                            </svg>
                            <span>Зарегистрироваться</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal js-modal" data-modal-name="sign-up">
    <div class="modal__wrap">
        <div class="modal__dialog js-modal-dialog" role="dialog" aria-modal="true">
            <button type="button" class="modal__close-btn btn btn--icon btn--sm js-modal-close">
                <span class="sr-only">Закрыть модальное окно</span>
                <svg aria-hidden="true">
                    <use xlink:href="images/sprite.svg#close"></use>
                </svg>
            </button>
            <div class="modal__content">
                <div class="modal__title">
                    <h2>Регистрация</h2>
                </div>
                <form class="modal__form">
                    <div class="form-input">
                        <label for="sign-up-name">Ваше имя*</label>
                        <input type="text" id="sign-up-name" placeholder='Иван Иванов' required>
                    </div>
                    <div class="form-input">
                        <label for="sign-up-phone">Номер телефона*</label>
                        <input type="tel" id="sign-up-phone" placeholder='+7 900 000-00-00' required>
                    </div>
                    <div class="form-password">
                        <label for="sign-up-password">Пароль*</label>
                        <input type="password" id="sign-up-password" placeholder='*******' required>
                        <div class="form-display-btn">
                            <input type="checkbox" id="sign-up-display-password">
                            <label for="sign-up-display-password">Показать пароль</label>
                        </div>
                    </div>
                    <div class="form-checkbox">
                        <input type="checkbox" id="sign-up-agreement">
                        <label for="sign-up-agreement">Я даю согласие на обработку персональных данных в&nbsp;соответствии
                            с&nbsp;<a href="./privacy-policy.html">Политикой конфиденциальности</a></label>
                    </div>
                    <div class="modal__btns">
                        <button type="button" class="btn btn--primary" data-modal-trigger="sign-up-success">
                            <svg aria-hidden="true">
                                <use xlink:href="images/sprite.svg#user-plus"></use>
                            </svg>
                            <span>Зарегистрироваться</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal js-modal" data-modal-name="sign-up-success">
    <div class="modal__wrap">
        <div class="modal__dialog js-modal-dialog" role="dialog" aria-modal="true">
            <button type="button" class="modal__close-btn btn btn--icon btn--sm js-modal-close">
                <span class="sr-only">Закрыть модальное окно</span>
                <svg aria-hidden="true">
                    <use xlink:href="images/sprite.svg#close"></use>
                </svg>
            </button>
            <div class="modal__content">
                <div class="modal__title">
                    <h2>Вы успешно зарегистрировались и&nbsp;можете оформить заказ</h2>
                </div>
                <div class="modal__btns">
                    <a href="./catalog.html" class="btn btn--primary">
                        <svg aria-hidden="true">
                            <use xlink:href="images/sprite.svg#catalog"></use>
                        </svg>
                        <span>В каталог</span>
                    </a>
                    <a href="./cart-auth.html" class="btn btn--secondary" data-modal-trigger="sign-up">
                        <svg aria-hidden="true">
                            <use xlink:href="images/sprite.svg#cart"></use>
                        </svg>
                        <span>В корзину</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal js-modal" data-modal-name="password-recovery">
    <div class="modal__wrap">
        <div class="modal__dialog js-modal-dialog" role="dialog" aria-modal="true">
            <button type="button" class="modal__close-btn btn btn--icon btn--sm js-modal-close">
                <span class="sr-only">Закрыть модальное окно</span>
                <svg aria-hidden="true">
                    <use xlink:href="images/sprite.svg#close"></use>
                </svg>
            </button>
            <div class="modal__content">
                <div class="modal__title">
                    <h2>Восстановление пароля</h2>
                </div>
                <form class="modal__form is-success">
                    <div class="form-input">
                        <label for="recovery-phone">Введите номер телефона, указанный при регистрации*</label>
                        <input type="tel" id="recovery-phone" placeholder='+7 900 000-00-00' required>
                    </div>
                    <div class="modal__btns">
                        <button type="button" class="btn btn--primary">
                            <svg aria-hidden="true">
                                <use xlink:href="images/sprite.svg#restore"></use>
                            </svg>
                            <span>Восстановить</span>
                        </button>
                    </div>
                    <span class="success-message">
                            <svg aria-hidden="true">
                                <use xlink:href="images/sprite.svg#check-circle"></use>
                            </svg>
                            <span>SMS с новым паролем отправлено на указанный номер&nbsp;телефона</span>
                        </span>
                </form>
            </div>
        </div>
    </div>
</div>
</body>

</html>
