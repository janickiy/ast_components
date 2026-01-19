(() => {
    const csrf = () => document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    const urls = () => {
        const w = window.Cart || {};
        return {
            add: w.addUrl || '/cart/add',
            qty: w.qtyUrl || '/cart/qty',
            remove: w.removeUrl || '/cart/remove',
            undo: w.undoUrl || '/cart/undo',
            toggle: w.toggleUrl || '/cart/toggle',
            selectAll: w.selectAllUrl || '/cart/select-all',
            checkout: w.checkoutUrl || '/cart/checkout',
            cart: w.cartUrl || '/cart',
        };
    };

    const postJSON = async (url, data) => {
        const res = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf(),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: JSON.stringify(data || {}),
        });

        let json = null;
        try { json = await res.json(); } catch (_) {}

        if (!res.ok) {
            if (res.status === 401 && json?.redirect) {
                window.location.href = json.redirect;
                return null;
            }
            console.error('Request failed', url, res.status, json);
            return null;
        }
        return json;
    };

    const setHeaderCartCount = (count) => {
        const el = document.querySelector('[data-cart-count]');
        if (el) el.textContent = String(count ?? 0);
    };

    const setSelectedCount = (count) => {
        const el = document.querySelector('[data-cart-selected-count]');
        if (el) el.textContent = String(count ?? 0);
    };

    const recalcSelectedCountFromUI = (page, items) => {
        let sum = 0;

        items.forEach((li) => {
            const cb = li.querySelector('[data-cart-select]') || li.querySelector('.js-cart-item-check');
            const qtyInput = li.querySelector('[data-cart-qty]') || li.querySelector('.js-cart-qty-input');

            // если позиция “pending remove” — обычно ты дисейблишь cb/qty, такие не считаем
            if (!cb || cb.disabled) return;
            if (!cb.checked) return;

            const qty = parseInt(qtyInput?.value || '0', 10) || 0;
            sum += Math.max(0, qty);
        });

        setSelectedCount(sum);
    };

    const dispatchInput = (el) => {
        if (!el) return;
        el.dispatchEvent(new Event('input', { bubbles: true }));
        el.dispatchEvent(new Event('change', { bubbles: true }));
    };

    const showOrderSuccessModal = (orderId) => {
        // если есть общий модальный код, который открывает по data-modal-trigger
        const trigger = document.querySelector('[data-modal-trigger="order-success"]');

        // если триггера нет — откроем руками через класс is-open
        const modal = openModal('order-success');

        if (modal) {
            const box = modal.querySelector('[data-order-success-id]');
            if (box) {
                box.textContent = orderId ? `Номер заказа: ${orderId}` : '';
            }

            const okBtn = modal.querySelector('.js-order-success-ok');
            const closeBtn = modal.querySelector('.js-modal-close');

            const finish = () => window.location.reload();

            if (okBtn) okBtn.onclick = finish;
            if (closeBtn) closeBtn.onclick = finish;

            // клик по оверлею тоже можно закрывать
            const wrap = modal.querySelector('.modal__wrap');
            if (wrap) {
                wrap.onclick = (e) => {
                    if (e.target === wrap) finish();
                };
            }
        }
    };

    const openModal = (name) => {
        const modal = document.querySelector(`.js-modal[data-modal-name="${name}"]`);
        if (!modal) return null;

        modal.classList.add('is-open'); // если у тебя другое имя класса — скажи, подстрою
        document.body.classList.add('is-modal-open');

        return modal;
    };

    const closeModal = (modal) => {
        if (!modal) return;
        modal.classList.remove('is-open');
        document.body.classList.remove('is-modal-open');
    };

    // -----------------------
    // CART PAGE (ОСТАВЛЯЕМ ТВОЙ — он рабочий)
    // -----------------------
    const initCartPage = () => {
        const page = document.querySelector('[data-cart-page]') || document.querySelector('.cart.container-sm');
        if (!page) return;

        const U = urls();
        const items = Array.from(page.querySelectorAll('[data-cart-item][data-product-id]'));
        recalcSelectedCountFromUI(page, items);

        const selectAll =
            page.querySelector('[data-cart-select-all]') ||
            page.querySelector('#cart-all-add');

        const getItemCheckboxes = () =>
            items
                .map(li => li.querySelector('[data-cart-select]') || li.querySelector('.js-cart-item-check'))
                .filter(cb => cb && !cb.disabled);

        const syncSelectAllFromItems = () => {
            if (!selectAll) return;
            const cbs = getItemCheckboxes();
            selectAll.checked = cbs.length > 0 && cbs.every(cb => cb.checked);
        };

        if (selectAll) {
            selectAll.addEventListener('change', async () => {
                const selected = !!selectAll.checked;

                // ✅ Визуально переключаем все чекбоксы сразу
                getItemCheckboxes().forEach(cb => {
                    cb.checked = selected;
                });
                recalcSelectedCountFromUI(page, items);

                // ✅ Отправляем один запрос на сервер
                await postJSON(U.selectAll, { selected });

                // (не обязательно) можно пересчитать selectAll ещё раз
                syncSelectAllFromItems();
            });
        }

        // debounce
        const debounceMap = new Map();
        const setDebounced = (key, fn, delay) => {
            if (debounceMap.has(key)) clearTimeout(debounceMap.get(key));
            debounceMap.set(key, setTimeout(fn, delay));
        };

        const showPendingUI = (item, pendingUntilUnix) => {
            const pendingBox = item.querySelector('[data-cart-pending]');
            const countdown = item.querySelector('[data-cart-countdown]');
            const qty = item.querySelector('[data-cart-qty]') || item.querySelector('.js-cart-qty-input');
            const removeBtn = item.querySelector('[data-cart-remove]') || item.querySelector('.js-cart-remove');
            const cb = item.querySelector('[data-cart-select]') || item.querySelector('.js-cart-item-check');

            if (qty) qty.disabled = true;
            if (removeBtn) removeBtn.disabled = true;
            if (cb) cb.disabled = true;
            recalcSelectedCountFromUI(page, items);
            syncSelectAllFromItems();

            if (pendingBox) pendingBox.style.display = '';

            const tick = () => {
                const now = Math.floor(Date.now() / 1000);
                const left = Math.max(0, pendingUntilUnix - now);
                if (countdown) countdown.textContent = String(left);
                if (left <= 0) {
                    window.location.reload();
                    return;
                }
                requestAnimationFrame(() => setTimeout(tick, 250));
            };
            tick();
        };

        items.forEach((item) => {
            const productId = parseInt(item.getAttribute('data-product-id'), 10);

            const cb =
                item.querySelector('[data-cart-select]') ||
                item.querySelector('.js-cart-item-check');

            if (cb) {
                cb.addEventListener('change', async () => {
                    await postJSON(U.toggle, { product_id: productId, selected: !!cb.checked });

                    // ✅ Пересчитываем "отметить все"
                    syncSelectAllFromItems();
                    recalcSelectedCountFromUI(page, items);
                });
            }

            const qtyInput =
                item.querySelector('[data-cart-qty]') ||
                item.querySelector('.js-cart-qty-input');

            const removeBtn =
                item.querySelector('[data-cart-remove]') ||
                item.querySelector('.js-cart-remove');

            const undoBtn =
                item.querySelector('[data-cart-undo]') ||
                item.querySelector('.js-cart-undo');

            // +/- (обязательно диспатчим input)
            const minusBtn =
                item.querySelector('[data-cart-step="-1"]') ||
                item.querySelector('.js-cart-qty-minus');

            const plusBtn =
                item.querySelector('[data-cart-step="1"]') ||
                item.querySelector('.js-cart-qty-plus');

            const stepHandler = (step) => {
                if (!qtyInput) return;
                const cur = parseInt(qtyInput.value || '0', 10) || 0;
                const next = Math.max(0, cur + step);
                qtyInput.value = String(next);
                dispatchInput(qtyInput);
                recalcSelectedCountFromUI(page, items);
            };

            if (minusBtn) minusBtn.addEventListener('click', () => stepHandler(-1));
            if (plusBtn) plusBtn.addEventListener('click', () => stepHandler(1));

            // pending
            const pendingUntil = item.getAttribute('data-pending-until');
            if (pendingUntil) showPendingUI(item, parseInt(pendingUntil, 10));

            if (qtyInput) {
                qtyInput.addEventListener('input', () => {
                    const raw = parseInt(qtyInput.value || '0', 10);
                    const qty = isNaN(raw) ? 0 : raw;
                    recalcSelectedCountFromUI(page, items);

                    setDebounced(`qty:${productId}`, async () => {
                        const json = await postJSON(U.qty, { product_id: productId, qty });
                        if (!json) return;

                        if (json.cart_count !== undefined) setHeaderCartCount(json.cart_count);

                        if (json.pending_remove_until) {
                            showPendingUI(item, parseInt(json.pending_remove_until, 10));
                        }
                    }, 250);
                });
            }

            if (removeBtn) {
                removeBtn.addEventListener('click', async () => {
                    const json = await postJSON(U.remove, { product_id: productId });
                    if (!json) return;

                    if (json.pending_remove_until) {
                        showPendingUI(item, parseInt(json.pending_remove_until, 10));
                    } else {
                        window.location.reload();
                    }
                });
            }

            if (undoBtn) {
                undoBtn.addEventListener('click', async () => {
                    const json = await postJSON(U.undo, { product_id: productId });
                    if (!json) return;

                    if (json.cart_count !== undefined) setHeaderCartCount(json.cart_count);
                    window.location.reload();
                });
            }
        });

        const checkoutBtn =
            page.querySelector('[data-cart-checkout]') ||
            page.querySelector('.js-cart-checkout');

        if (checkoutBtn) {
            checkoutBtn.addEventListener('click', async () => {
                const json = await postJSON(U.checkout, {});
                if (!json) return;

                if (!json.ok) {
                    alert('Выберите товары для оформления заказа.');
                    return;
                }

                if (json.cart_count !== undefined) setHeaderCartCount(json.cart_count);

                // ВОТ ЭТО ДОБАВИТЬ:
                showOrderSuccessModal(json.order_id);

                // НЕ ДЕЛАЕМ reload сразу, иначе модалку не увидят
            });
        }
        // ✅ при загрузке страницы выставляем общий чекбокс корректно
        syncSelectAllFromItems();
    };

    // -----------------------
    // CATALOG PAGE (твоя версия)
    // -----------------------
    const initCatalog = () => {
        const U = urls();
        const cards = Array.from(document.querySelectorAll('[data-catalog-product]'));
        if (!cards.length) return;

        const isVisible = (el) => !!el && !!(el.offsetWidth || el.offsetHeight || el.getClientRects().length);

        cards.forEach((card) => {
            const productId = parseInt(card.getAttribute('data-catalog-product'), 10);
            const qtyInput = card.querySelector('[data-catalog-qty]');
            const addBtn = card.querySelector('[data-catalog-add]');
            const inCartBtn = card.querySelector('[data-catalog-incart]');

            const isInCartNow = () => isVisible(inCartBtn) && !isVisible(addBtn);

            card.querySelectorAll('[data-qty-step]').forEach((btn) => {
                btn.addEventListener('click', () => {
                    if (!qtyInput) return;
                    const step = parseInt(btn.getAttribute('data-qty-step') || '0', 10);
                    const cur = parseInt(qtyInput.value || '0', 10) || 0;
                    const next = Math.max(0, cur + step);
                    qtyInput.value = String(next);

                    // ВАЖНО: если товара ещё нет в корзине — не шлём запрос
                    if (isInCartNow()) dispatchInput(qtyInput);
                });
            });

            if (addBtn) {
                addBtn.addEventListener('click', async () => {
                    const qty = qtyInput ? (parseInt(qtyInput.value || '1', 10) || 1) : 1;
                    const safeQty = Math.max(1, qty);

                    const json = await postJSON(U.add, { product_id: productId, qty: safeQty });
                    if (!json) return;

                    if (json.cart_count !== undefined) setHeaderCartCount(json.cart_count);

                    if (addBtn) addBtn.style.display = 'none';
                    if (inCartBtn) inCartBtn.style.display = '';
                });
            }

            if (inCartBtn) {
                inCartBtn.addEventListener('click', () => {
                    window.location.href = U.cart;
                });
            }

            if (qtyInput) {
                let t = null;
                qtyInput.addEventListener('input', () => {
                    if (!isInCartNow()) return;

                    if (t) clearTimeout(t);
                    t = setTimeout(async () => {
                        const qty = parseInt(qtyInput.value || '0', 10) || 0;

                        const json = await postJSON(U.qty, { product_id: productId, qty });
                        if (!json) return;

                        if (json.cart_count !== undefined) setHeaderCartCount(json.cart_count);

                        if (qty <= 0) {
                            if (addBtn) addBtn.style.display = '';
                            if (inCartBtn) inCartBtn.style.display = 'none';
                            qtyInput.value = '1';
                        }
                    }, 250);
                });
            }
        });
    };

    // -----------------------
    // PRODUCT PAGE (добавляем)
    // Требует в product.blade:
    // data-product-page data-product-id
    // data-product-qty
    // data-product-add
    // data-product-incart
    // и кнопки +/- с data-qty-step="-1/1"
    // -----------------------
    const initProductPage = () => {
        const U = urls();
        const root = document.querySelector('[data-product-page][data-product-id]');
        if (!root) return;

        const productId = parseInt(root.getAttribute('data-product-id'), 10);

        const qtyInput = root.querySelector('[data-product-qty]');
        const addBtn = root.querySelector('[data-product-add]');
        const inCartBtn = root.querySelector('[data-product-incart]');

        const isVisible = (el) => !!el && !!(el.offsetWidth || el.offsetHeight || el.getClientRects().length);
        const isInCartNow = () => isVisible(inCartBtn) && !isVisible(addBtn);

        // +/- : если не в корзине — только input
        //       если в корзине — input + отправка qty
        root.querySelectorAll('[data-qty-step]').forEach((btn) => {
            btn.addEventListener('click', () => {
                if (!qtyInput) return;

                const step = parseInt(btn.getAttribute('data-qty-step') || '0', 10);
                const cur = parseInt(qtyInput.value || '0', 10) || 0;
                const next = Math.max(0, cur + step);

                qtyInput.value = String(next);

                if (isInCartNow()) {
                    dispatchInput(qtyInput);
                }
            });
        });

        // ADD
        if (addBtn) {
            addBtn.addEventListener('click', async () => {
                const qty = qtyInput ? (parseInt(qtyInput.value || '1', 10) || 1) : 1;
                const safeQty = Math.max(1, qty);

                const json = await postJSON(U.add, { product_id: productId, qty: safeQty });
                if (!json) return;

                if (json.cart_count !== undefined) setHeaderCartCount(json.cart_count);

                addBtn.style.display = 'none';
                if (inCartBtn) inCartBtn.style.display = '';
                if (qtyInput) qtyInput.value = String(safeQty);
            });
        }

        // go to cart
        if (inCartBtn) {
            inCartBtn.addEventListener('click', () => {
                window.location.href = U.cart;
            });
        }

        // input change — только если уже в корзине
        if (qtyInput) {
            let t = null;
            qtyInput.addEventListener('input', () => {
                if (!isInCartNow()) return;

                if (t) clearTimeout(t);
                t = setTimeout(async () => {
                    const qty = parseInt(qtyInput.value || '0', 10) || 0;

                    const json = await postJSON(U.qty, { product_id: productId, qty });
                    if (!json) return;

                    if (json.cart_count !== undefined) setHeaderCartCount(json.cart_count);

                    if (qty <= 0) {
                        if (addBtn) addBtn.style.display = '';
                        if (inCartBtn) inCartBtn.style.display = 'none';
                        qtyInput.value = '1';
                    }
                }, 250);
            });
        }
    };

    document.addEventListener('DOMContentLoaded', () => {
        initCartPage();
        initCatalog();
        initProductPage();
    });
})();
