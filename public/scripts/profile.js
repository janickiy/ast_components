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
                location.reload(); // Перезагружаем страницу для показа данных компании
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

        // Закрываем модалку через 1.5 секунды
        setTimeout(() => {
            const modal = form.closest('.js-modal');
            if (modal) {
                modal.classList.remove('is-open');
                document.body.classList.remove('no-scroll');
            }
        }, 1500);
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
        if (!password || password.trim() === '') {
            formData.delete('password');
            formData.delete('password_confirmation');
        }

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
                updateDOM('profile', data.data);
                showSuccess('general');
                // Обновляем страницу для отображения всех изменений
                setTimeout(() => location.reload(), 1000);
            } else {
                showErrors('general', data.errors || {});
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showErrors('general', { general: ['Произошла ошибка при сохранении. Попробуйте позже.'] });
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
                updateDOM('company', data.data);
                showSuccess('company');
                // Обновляем страницу для отображения всех изменений
                setTimeout(() => location.reload(), 1000);
            } else {
                showErrors('company', data.errors || {});
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showErrors('company', { general: ['Произошла ошибка при сохранении. Попробуйте позже.'] });
        });
    }

    /**
     * Обработка выхода
     */
    function handleLogout(e) {
        e.preventDefault();

        fetch('/logout', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            // Показываем уведомление об успешном выходе
            if (data.success) {
                // Создаем элемент уведомления
                const notification = document.createElement('div');
                notification.className = 'logout-notification';
                notification.style.cssText = 'position: fixed; top: 20px; right: 20px; background: #4caf50; color: white; padding: 15px 20px; border-radius: 5px; box-shadow: 0 2px 10px rgba(0,0,0,0.2); z-index: 10000; font-size: 14px;';
                notification.textContent = 'Вы успешно вышли из своего аккаунта';
                document.body.appendChild(notification);

                // Удаляем уведомление через 3 секунды
                setTimeout(() => {
                    notification.style.opacity = '0';
                    notification.style.transition = 'opacity 0.3s';
                    setTimeout(() => notification.remove(), 300);
                }, 3000);

                // Перенаправляем через небольшую задержку, чтобы показать уведомление
                setTimeout(() => {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        window.location.href = '/catalog';
                    }
                }, 1000);
            } else {
                // Если что-то пошло не так, просто перенаправляем
                window.location.href = data.redirect || '/catalog';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // В случае ошибки все равно выходим и перенаправляем
            window.location.href = '/catalog';
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
    }

    // Запускаем после загрузки DOM
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
