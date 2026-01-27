<div data-tab="account-claims" class="claims">
    <section class="account__container">
        <div class="account__section-header">
            <div class="account__section-title">
                <h2>Претензии</h2>
            </div>
            <button type="button" class="btn btn--tertiary btn--sm" data-modal-trigger="create-claim">
                <svg aria-hidden="true">
                    <use xlink:href="{{ url('/images/sprite.svg#plus') }}"></use>
                </svg>
                <span>Создать</span>
            </button>
        </div>
        <div class="account__table">
            <div class="account__table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>Тип претензии</th>
                        <th>По счету</th>
                        <th>Позиция</th>
                        <th>Количество<br>в счете</th>
                        <th>Количество<br>с браком</th>
                        <th>Статус претензии</th>
                        <th>Результат<br>рассмотрения</th>
                        <th>Бланк</th>
                        <th>Фото</th>
                    </tr>
                    </thead>
                    <tbody>
                    @include('frontend.profile.partials.complaints-rows', ['complaints' => $complaints ?? []])
                    </tbody>
                </table>
            </div>
        </div>
        @if ($complaints->hasMorePages())
            <button type="button" class="account__more-btn btn btn--secondary">
                <span>Показать еще</span>
            </button>
        @endif
    </section>
</div>