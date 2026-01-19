@extends('layouts.frontend')

@section('title', $title)

@section('description', $meta_description)

@section('keywords', $meta_keywords)

@section('seo_url_canonical', $seo_url_canonical)

@section('css')

@endsection

@section('content')

    @include('layouts._breadcrumbs')

    <div class="conditions container-sm">
        <section>
            <div class="conditions__section-title">
                <h2>Способы доставки</h2>
            </div>
            <ul class="conditions__list">
                <li class="conditions__item pickup">
                    <div class="conditions__item-left">
                        <div class="conditions__item-title">
                            <svg aria-hidden="true">
                                <use xlink:href="{{ url('/images/sprite.svg#undertake-delivery') }}"></use>
                            </svg>
                            <h3>Самовывоз</h3>
                        </div>
                        <p class="conditions__item-text">Вы можете самостоятельно забрать заказ с нашего склада в удобное для вас время (по предварительной договоренности)</p>
                        <div class="conditions__info">
                            <div class="conditions__info-row">
                                <div class="conditions__info-title">
                                    <svg aria-hidden="true" class="orange">
                                        <use xlink:href="{{ url('/images/sprite.svg#location') }}"></use>
                                    </svg>
                                    <span>Адрес</span>
                                </div>
                                <div class="conditions__info-text">
                                    {!! SettingsHelper::getInstance()->getValueForKey('YANDEX_MAP') !!}
                                </div>
                            </div>
                            <div class="conditions__info-row">
                                <div class="conditions__info-title">
                                    <svg aria-hidden="true" class="orange">
                                        <use xlink:href="{{ url('/images/sprite.svg#time') }}"></use>
                                    </svg>
                                    <span>Время работы склада</span>
                                </div>
                                <div class="conditions__info-text grid">
                                    <span>Понедельник - Четверг</span>
                                    <span>с 8-30 до 17-30</span>
                                    <span>Пятница</span>
                                    <span>с 8-30 до 16-30</span>
                                    <span>Суббота, Воскресенье</span>
                                    <span>выходные</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="conditions__item-map" id="yandex-map"></div>
                </li>
                <li class="conditions__item">
                    <div class="conditions__item-title">
                        <svg aria-hidden="true">
                            <use xlink:href="{{ url('/images/sprite.svg#delivery-car') }}"></use>
                        </svg>
                        <h3>Транспортные компании</h3>
                    </div>
                    <p class="conditions__item-text">Мы сотрудничаем с надежными транспортными компаниями, обеспечивающими доставку по всей территории страны. Стоимость и сроки доставки рассчитываются индивидуально в зависимости от веса, объема и пункта назначения заказа.</p>
                    <div class="conditions__companies">
                        <a class="conditions__company" href="http://www.cdek.ru" target="_blank" rel="noopener noreferrer">
                            <span class="sr-only">Сайт компании СДЕК</span>
                            <img src="{{ url('/images/cdek-logo.svg') }}" alt="СДЕК логотип">
                        </a>
                        <a class="conditions__company" href="http://www.dellin.ru" target="_blank" rel="noopener noreferrer">
                            <span class="sr-only">Сайт компании Деловые линии</span>
                            <img src="{{ url('/images/dl-logo.svg') }}" alt="Деловые линии логотип">
                        </a>
                        <a class="conditions__company" href="http://www.major-express.ru" target="_blank" rel="noopener noreferrer">
                            <span class="sr-only">Сайт компании СДЕК</span>
                            <picture>
                                <source srcset="{{ url('/images/major-e-logo.webp') }}" type="image/webp">
                                <img src="{{ url('/images/major-e-logo.png') }}" alt="Major Express логотип">
                            </picture>
                        </a>
                    </div>
                </li>
                <li class="conditions__item">
                    <div class="conditions__item-title">
                        <svg aria-hidden="true">
                            <use xlink:href="{{ url('/images/sprite.svg#courier') }}"></use>
                        </svg>
                        <h3>Курьерская доставка</h3>
                    </div>
                    <p class="conditions__item-note">БЕСПЛАТНАЯ ДОСТАВКА курьером “прямо в руки” по Москве от 10 000 рублей.</p>
                    <p class="conditions__item-text">Если у вас крупный заказ или специфические требования к доставке, мы готовы обсудить индивидуальные условия. <a href="{{ route('frontend.contacts') }}">Свяжитесь с нами</a> любым удобным способом.</p>
                </li>
            </ul>
        </section>
        <section>
            <div class="conditions__section-title">
                <h2>Оплата</h2>
            </div>
            <div class="conditions__item payment">
                <div class="conditions__item-top">
                    <div>
                        <div class="conditions__item-title">
                            <svg aria-hidden="true">
                                <use xlink:href="{{ url('/images/sprite.svg#card') }}"></use>
                            </svg>
                            <h3>Безналичный расчет</h3>
                        </div>
                        <p class="conditions__item-text">Основной способ оплаты для юридических лиц. После оформления заказа вам будет выставлен счет, который можно оплатить через банк путем перечисления денежных средств на расчетный счет.</p>
                    </div>
                    <div class="conditions__details-btns">
                        <a href="{{ SettingsHelper::getInstance()->getValueForKey('DETAILS') }}" download="logo.svg" class="btn btn--secondary">
                            <span>Скачать реквизиты</span>
                            <svg aria-hidden="true">
                                <use xlink:href="{{ url('/images/sprite.svg#download') }}"></use>
                            </svg>
                        </a>
                        <a href="{{ route('frontend.page', ['slug' => 'rekvizityi-kompanii']) }}" class="btn btn--secondary">
                            <span>Реквизиты на сайте</span>
                            <svg aria-hidden="true">
                                <use xlink:href="{{ url('/images/sprite.svg#arrow-right') }}"></use>
                            </svg>
                        </a>
                    </div>
                </div>
                <ul class="conditions__payment-list">
                    <li class="conditions__payment-item">
                        <h4>1. Оплата по договорным условиям</h4>
                        <p>Для крупных заказов и постоянных клиентов предусмотрены индивидуальные условия оплаты, включая отсрочки платежей, которые обсуждаются в рамках отдельного договора.</p>
                    </li>
                    <li class="conditions__payment-item">
                        <h4>2. Предоплата/Частичная предоплата</h4>
                        <p>В зависимости от объема заказа и истории сотрудничества может потребоваться предоплата в размере 50% от стоимости заказа.</p>
                    </li>
                </ul>
                <div class="conditions__details-btns">
                    <a href="{{ SettingsHelper::getInstance()->getValueForKey('DETAILS') }}" download="logo.svg" class="btn btn--secondary">
                        <span>Скачать реквизиты</span>
                        <svg aria-hidden="true">
                            <use xlink:href="{{ url('/images/sprite.svg#downloa') }}d"></use>
                        </svg>
                    </a>
                    <a href="{{ route('frontend.page', ['slug' => 'rekvizityi-kompanii']) }}l" class="btn btn--secondary">
                        <span>Реквизиты на сайте</span>
                        <svg aria-hidden="true">
                            <use xlink:href="{{ url('/images/sprite.svg#arrow-right') }}"></use>
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    </div>

@endsection

@section('js')



@endsection

