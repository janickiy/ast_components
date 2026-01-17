<div data-tab="account-orders" class="orders">
    <section class="account__container">
        <div class="account__section-title">
            <h2>Мои заказы</h2>
        </div>
        <div class="account__table">
            <div class="account__table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>Номер заказа</th>
                        <th>Дата создания</th>
                        <th>Сумма заказа</th>
                        <th>Ожидаемая<br>дата доставки</th>
                        <th>Статус заказа</th>
                        <th>Счет на оплату</th>
                    </tr>
                    </thead>
                    <tbody>
                        @include('frontend.profile.partials.orders-rows', ['orders' => $orders ?? []])
                    </tbody>
                </table>
            </div>
        </div>
        @if ($orders->hasMorePages())
            <button type="button" class="account__more-btn btn btn--secondary">
                <span>Показать еще</span>
            </button>
        @endif
    </section>
</div>

<!-- Шаблон для модалки --->
<div class="modal modal--order-details js-modal" data-modal-name="order-details">
    <div class="modal__wrap">
        <div class="modal__dialog js-modal-dialog" role="dialog" aria-modal="true">
            <button type="button" class="modal__close-btn btn btn--icon btn--sm js-modal-close">
                <span class="sr-only">Закрыть модальное окно</span>
                <svg aria-hidden="true">
                    <use xlink:href="{{ url('/images/sprite.svg#close') }}"></use>
                </svg>
            </button>
            <div class="modal__content">
                <div class="modal__title">
                    <h2>Детали заказа</h2>
                </div>
                <div class="modal__order-list">
                    <div class="modal__order-list">
                        <div class="js-modal-order-list"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

