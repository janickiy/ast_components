<div data-tab="account-requests" class="requests">
    <section class="account__container">
        <div class="account__section-title">
            <h2>Мои запросы</h2>
        </div>
        <div class="account__table">
            <div class="account__table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>Номер запроса</th>
                        <th>Дата создания</th>
                        <th>Запрашиваемая<br>номенклатура</th>
                        <th>Запрашиваемое<br>количество</th>
                        <th>Статус запроса</th>
                    </tr>
                    </thead>
                    <tbody id="requestsTableBody">
                    @include('frontend.profile.partials.requests-rows', ['requests' => $requests ?? []])
                    </tbody>
                </table>
            </div>
        </div>
        @if ($requests->hasMorePages())
            <button
                    type="button"
                    class="account__more-btn btn btn--secondary"
                    id="loadMoreRequests"
                    data-next-page="2"
            >
                <span>Показать еще</span>
            </button>
        @endif
    </section>
</div>
