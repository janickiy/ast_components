(function() {
    'use strict';

    // Получаем CSRF токен из meta тега
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    if (!csrfToken) {
        console.error('CSRF token not found');
        return;
    }

    // Маппинг полей для обновления DOM после успешного сохранения
    const fieldMapping = {
        profile: {
            'name': '[data-field="name"]',
            'email': '[data-field="email"]',
            'phone': '[data-field="phone"]'
        },
        company: {
            'name': '[data-field="company-name"]',
            'inn': '[data-field="inn"]',
            'contact_person': '[data-field="contact_person"]',
            'phone': '[data-field="company-phone"]',
            'email': '[data-field="company-email"]'
        }
    };

    /**
     * Показать ошибки валидации в модалке
     */
    function showErrors(formType, errors) {
        const errorsContainer = document.getElementById(`${formType}-info-errors`);
        if (!errorsContainer) return;

        errorsContainer.innerHTML = '';
        errorsContainer.style.display = 'block';

        // Создаем блок с ошибками
        const errorList = document.createElement('div');
        errorList.className = 'alert alert-danger';
        
        const errorItems = [];
        for (const [field, messages] of Object.entries(errors)) {
            if (Array.isArray(messages)) {
                messages.forEach(msg => errorItems.push(msg));
            } else {
                errorItems.push(messages);
            }
        }

        if (errorItems.length > 0) {
            errorList.innerHTML = '<ul style="margin: 0; padding-left: 20px;"><li>' + errorItems.join('</li><li>') + '</li></ul>';
            errorsContainer.appendChild(errorList);
        }

        // Подсветка полей с ошибками
        Object.keys(errors).forEach(fieldName => {
            const field = document.querySelector(`[name="${fieldName}"]`);
            if (field) {
                field.classList.add('error');
                const fieldContainer = field.closest('.form-input, .form-password');
                if (fieldContainer) {
                    fieldContainer.classList.add('has-error');
                }
            }
        });
    }

    /**
     * Скрыть ошибки и убрать подсветку
     */
    function clearErrors(formType) {
        const errorsContainer = document.getElementById(`${formType}-info-errors`);
        if (errorsContainer) {
            errorsContainer.innerHTML = '';
            errorsContainer.style.display = 'none';
        }

        // Убираем подсветку со всех полей
        const form = document.getElementById(`${formType}-info-form`);
        if (form) {
            form.querySelectorAll('.error, .has-error').forEach(el => {
                el.classList.remove('error', 'has-error');
            });
        }
    }

    function setLoading(formType, isLoading) {
        const form = document.getElementById(`${formType}-info-form`);
        if (!form) return;

        const loader = form.querySelector('.loading-message');
        const submitBtn = form.querySelector('[type="submit"]');

        if (loader) loader.style.display = isLoading ? 'flex' : 'none';
        if (submitBtn) submitBtn.disabled = isLoading;
    }

    /**
     * Обновить DOM после успешного сохранения
     */
    function updateDOM(formType, data) {
        const mapping = fieldMapping[formType];
        if (!mapping) return;

        Object.entries(mapping).forEach(([fieldKey, selector]) => {
            const element = document.querySelector(selector);
            if (element && data[fieldKey] !== undefined) {
                element.textContent = data[fieldKey] || '';
            }
        });

        // Если это компания и данные появились, показываем секцию компании
        if (formType === 'company' && data.name) {
            const profileInfo = document.querySelector('.profile__info');
            if (profileInfo && profileInfo.querySelector('.profile__empty')) {

            }
        }
    }

    /**
     * Показать сообщение об успехе
     */
    function showSuccess(formType) {
        const form = document.getElementById(`${formType}-info-form`);
        if (!form) return;

        const successMessage = form.querySelector('.success-message');

        if (successMessage) {
            successMessage.style.display = 'flex';
            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 3000);
        }

        // // Закрываем модалку через 1.5 секунды
        // setTimeout(() => {
        //     const modal = form.closest('.js-modal');
        //     if (modal) {
        //         modal.classList.remove('is-open');
        //         document.body.classList.remove('no-scroll');
        //     }
        // }, 1500);
    }

    /**
     * Обработка отправки формы профиля
     */
    function handleProfileSubmit(e) {
        e.preventDefault();
        clearErrors('general');

        const form = e.target;
        const formData = new FormData(form);

        // Если пароль не заполнен, удаляем поля пароля из FormData
        const password = formData.get('password');
        const passwordConfirmation = formData.get('password_confirmation');

        // 👉 Проверка совпадения паролей
        if (password || passwordConfirmation) {
            if (!password || !passwordConfirmation) {
                showErrors('general', {
                    password: ['Введите пароль и подтверждение']
                });
                return;
            }

            if (password !== passwordConfirmation) {
                showErrors('general', {
                    password: ['Пароли не совпадают']
                });
                return;
            }
        }
        if (!password || password.trim() === '') {
            formData.delete('password');
            formData.delete('password_confirmation');
        }

        // ✅ показываем "Загрузка..."
        setLoading('general', true);
        fetch('/profile/update', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
              //  updateDOM('profile', data.data);
                showSuccess('general');
                // Обновляем страницу для отображения всех изменений
                setTimeout(() => {
                    window.location = '/profile';
                }, 2000)
            } else {
                showErrors('general', data.errors || {});
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showErrors('general', { general: ['Произошла ошибка при сохранении. Попробуйте позже.'] });
        })
        .finally(() => {
            // ✅ скрываем "Загрузка..." всегда
            setLoading('general', false);
        });
    }

    /**
     * Обработка отправки формы компании
     */
    function handleCompanySubmit(e) {
        e.preventDefault();
        clearErrors('company');

        const form = e.target;
        const formData = new FormData(form);

        // ✅ показываем "Загрузка..."
        setLoading('company', true);

        fetch('/profile/company', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {

            if (data.success) {
                //updateDOM('company', data.data);
                showSuccess('company');

                setTimeout(() => {
                    window.location = '/profile';
                }, 2000)
                // Обновляем страницу для отображения всех изменений
                //setTimeout(() => location.reload(), 1000);
            } else {
                showErrors('company', data.errors || {});
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showErrors('company', { general: ['Произошла ошибка при сохранении. Попробуйте позже.'] });
        })
        .finally(() => {
            // ✅ показываем "Загрузка..."
            setLoading('company', false);
        });
    }

    /**
     * Инициализация
     */
    function init() {
        // Обработчики форм
        const profileForm = document.getElementById('general-info-form');
        if (profileForm) {
            profileForm.addEventListener('submit', handleProfileSubmit);
        }

        const companyForm = document.getElementById('company-info-form');
        if (companyForm) {
            companyForm.addEventListener('submit', handleCompanySubmit);
        }

        // Обработчик кнопки выхода
        const logoutBtn = document.getElementById('logout-btn');
        if (logoutBtn) {
            logoutBtn.addEventListener('click', handleLogout);
        }

        // Обработчики показа/скрытия пароля
        const passwordCheckboxes = document.querySelectorAll('#general-info-display-password, #general-info-display-repeat-password');
        passwordCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const passwordField = this.id === 'general-info-display-password' 
                    ? document.getElementById('general-info-password')
                    : document.getElementById('general-info-repeat-password');
                if (passwordField) {
                    passwordField.type = this.checked ? 'text' : 'password';
                }
            });
        });

        // Очистка ошибок при изменении полей
        const forms = [profileForm, companyForm].filter(f => f);
        forms.forEach(form => {
            form.querySelectorAll('input, textarea, select').forEach(field => {
                field.addEventListener('input', function() {
                    this.classList.remove('error');
                    const container = this.closest('.form-input, .form-password');
                    if (container) {
                        container.classList.remove('has-error');
                    }
                });
            });
        });

        initClaimForm();
        initAccountLoadMore();
    }

    /**
     * Инициализация кнопки "Показать еще" в личном кабинете
     */
    function initAccountLoadMore() {
        const loadMoreButtons = document.querySelectorAll('.js-account-load-more');

        loadMoreButtons.forEach(button => {
            const listKey = button.dataset.list;
            const step = Number(button.dataset.step) || 10;

            if (!listKey) {
                button.style.display = 'none';
                return;
            }

            const items = Array.from(document.querySelectorAll(`.js-account-item[data-list="${listKey}"]`));

            if (items.length === 0) {
                button.style.display = 'none';
                return;
            }

            let visibleCount = Math.min(step, items.length);

            const updateVisibility = () => {
                items.forEach((item, index) => {
                    item.style.display = index < visibleCount ? '' : 'none';
                });

                button.style.display = visibleCount >= items.length ? 'none' : '';
            };

            updateVisibility();

            button.addEventListener('click', () => {
                visibleCount = Math.min(visibleCount + step, items.length);
                updateVisibility();
            });
        });
    }

    // Инициализация показа моих заказов
    function initOrder() {
        let page = Number(new URLSearchParams(window.location.search).get('page') || 1);

        const tab = document.querySelector('[data-tab="account-orders"]');
        const tbody = tab?.querySelector('tbody');
        const btn = tab?.querySelector('.account__more-btn');

        function openModal() {
            const modal = document.querySelector(`.modal--order-details`);
            if (!modal) return;

            modal.classList.add('is-open');
            document.body.classList.add('modal-open');

            // фокус для доступности
            const dialog = modal.querySelector('.js-modal-dialog');
            dialog?.focus();
        }

        function handleOrderDetailsClick(btn) {
            const orderId = btn.dataset.orderId;
            if (!orderId) return;

            const tpl = document.getElementById(`order-items-${orderId}`);
            const target = document.querySelector(
                '[data-modal-name="order-details"] .js-modal-order-list'
            );

            if (!tpl || !target) return;

            target.innerHTML = '';
            target.appendChild(tpl.content.cloneNode(true));
            openModal()
        }

        function getParams() {
            return new URLSearchParams(window.location.search);
        }

        function updateUrl(params) {
            const newUrl = `${window.location.pathname}?${params.toString()}`;
            window.history.pushState({}, '', newUrl);
        }

        function buildAjaxUrl(params) {
            // ВАЖНО: URL строится от текущего origin => будет https на https-странице
            const url = new URL('/profile/orders', window.location.origin); // <-- подставь свой путь
            params.forEach((value, key) => url.searchParams.set(key, value));
            return url.toString();
        }

        btn?.addEventListener('click', async () => {
            if (!tbody) return;

            btn.disabled = true;

            const params = getParams();
            const nextPage = page + 1;
            params.set('page', String(nextPage));

            try {
                const res = await fetch(buildAjaxUrl(params), {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    credentials: 'same-origin',
                });

                if (!res.ok) {
                    console.error('Orders AJAX failed:', res.status, await res.text());
                    btn.disabled = false;
                    return;
                }

                const data = await res.json();

                tbody.insertAdjacentHTML('beforeend', data.html);

                page = nextPage;
                //updateUrl(params);

                if (!data.hasMore) btn.style.display = 'none';
            } catch (e) {
                console.error('Orders AJAX error:', e);
            } finally {
                btn.disabled = false;
            }

        });

        document.addEventListener('click', (e) => {
            const btn = e.target.closest('.js-order-details-btn');
            if (!btn) return;

            handleOrderDetailsClick(btn);
        });
    }

    /**
     * Инициализация формы создания претензии
     */
    function initClaimForm() {
        const orderSelect = document.getElementById('create-claim-invoice-numb');
        const productSelect = document.getElementById('create-claim-product');
        const orderCountInput = document.getElementById('create-claim-count-invoice');

        if (!orderSelect || !productSelect || !orderCountInput) {
            return;
        }

        const updateProductVisibility = () => {
            const selectedOrderId = orderSelect.value;
            const options = Array.from(productSelect.options);

            options.forEach(option => {
                const orderId = option.dataset.orderId;
                option.hidden = orderId && orderId !== selectedOrderId;
            });

            const firstVisible = options.find(option => !option.hidden);
            if (firstVisible) {
                productSelect.value = firstVisible.value;
                productSelect.disabled = false;
                productSelect.required = true;
            } else {
                productSelect.value = '';
                productSelect.disabled = true;
                productSelect.required = false;
            }
        };

        const updateOrderCount = () => {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            orderCountInput.value = selectedOption?.dataset.orderCount || '';
        };

        updateProductVisibility();
        updateOrderCount();

        orderSelect.addEventListener('change', () => {
            updateProductVisibility();
            updateOrderCount();
        });

        productSelect.addEventListener('change', updateOrderCount);
    }

    // Запускаем после загрузки DOM
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
        document.addEventListener('DOMContentLoaded', initOrder);
    } else {
        init();
        initOrder();
    }
})();

