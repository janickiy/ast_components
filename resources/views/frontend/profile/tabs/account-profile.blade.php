<div data-tab="account-profile" class="profile">
    <section>
        <div class="account__section-header">
            <div class="account__section-title">
                <h2>Общая информация</h2>
            </div>
            <button type="button" class="profile__edit-btn btn btn--icon" data-modal-trigger="general-info">
                <span class="sr-only">Редактировать общую информацию</span>
                <svg aria-hidden="true">
                    <use xlink:href="{{ url('/images/sprite.svg#edit') }}"></use>
                </svg>
            </button>
        </div>
        <div class="profile__info">
            <dl class="profile__list general">
                <div class="profile__point">
                    <dt class="profile__point-title">Электронная почта</dt>
                    <dd class="profile__point-text">{{ Auth::guard('customer')->user()->email }}</dd>
                </div>
                <div class="profile__point">
                    <dt class="profile__point-title">Имя</dt>
                    <dd class="profile__point-text">{{ Auth::guard('customer')->user()->name }}</dd>
                </div>
                <div class="profile__point">
                    <dt class="profile__point-title">Номер телефона</dt>
                    <dd class="profile__point-text">{{ Auth::guard('customer')->user()->phone }}</dd>
                </div>
                <div class="profile__point">
                    <dt class="profile__point-title">Пароль</dt>
                    <dd class="profile__point-text">***********</dd>
                </div>
            </dl>
        </div>
    </section>
    <section>
        <div class="account__section-header">
            <div class="account__section-title">
                <h2>Информация о&nbsp;компании</h2>
            </div>
            <button type="button" class="profile__edit-btn btn btn--icon" data-modal-trigger="company-info">
                <span class="sr-only">Редактировать информацию о компании</span>
                <svg aria-hidden="true">
                    <use xlink:href="{{ url('/images/sprite.svg#edit') }}"></use>
                </svg>
            </button>
        </div>
        <div class="profile__info">
            <dl class="profile__list">
                <div class="profile__point">
                    <dt class="profile__point-title">Компания</dt>
                    <dd class="profile__point-text">{{ Auth::guard('customer')->user()->company?->name }}</dd>
                </div>
                <div class="profile__point">
                    <dt class="profile__point-title">ИНН</dt>
                    <dd class="profile__point-text">{{ Auth::guard('customer')->user()->company?->inn }}</dd>
                </div>
            </dl>
            <dl class="profile__list">
                <div class="profile__point">
                    <dt class="profile__point-title">Контактное лицо</dt>
                    <dd class="profile__point-text">{{ Auth::guard('customer')->user()->company?->contact_person }}</dd>
                </div>
                <div class="profile__point">
                    <dt class="profile__point-title">Номер телефона</dt>
                    <dd class="profile__point-text">{{ Auth::guard('customer')->user()->company?->phone }}</dd>
                </div>
                <div class="profile__point">
                    <dt class="profile__point-title">Электронная почта</dt>
                    <dd class="profile__point-text">{{ Auth::guard('customer')->user()->company?->email }}</dd>
                </div>
            </dl>
        </div>
    </section>
</div>