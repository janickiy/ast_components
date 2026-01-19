(() => {
    const csrf = () => {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    };

    const urls = () => {
        const w = window.Cart || {};
        return {
            add: w.addUrl || '/cart/add',
            qty: w.qtyUrl || '/cart/set-qty',
            remove: w.removeUrl || '/cart/remove',
            undo: w.undoUrl || '/cart/undo-remove',
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
            if (res.status === 401 && json && json.redirect) {
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

    // -----------------------
    // CART PAGE
    // -----------------------
    const initCartPage = () => {
        const page = document.querySelector('[data-cart-page]');
        if (!page) return;

        const U = urls();
        const items = Array.from(document.querySelectorAll('[data-cart-item][data-product-id]'));

        // SELECT ALL
        const selectAll = document.querySelector('[data-cart-select-all]');
        if (selectAll) {
            selectAll.addEventListener('change', async () => {
                const selected = !!selectAll.checked;
                await postJSON(U.selectAll, { selected });
            });
        }

        // per-item select
        items.forEach((item) => {
            const productId = parseInt(item.getAttribute('data-product-id'), 10);
            const cb = item.querySelector('[data-cart-select]');
            if (cb) {
                cb.addEventListener('change', async () => {
                    await postJSON(U.toggle, {
                        product_id: productId,
                        selected: !!cb.checked,
                    });

                    if (selectAll) {
                        const all = items
                            .map(x => x.querySelector('[data-cart-select]'))
                            .filter(x => x && !x.disabled);
                        selectAll.checked = all.length > 0 && all.every(x => x.checked);
                    }
                });
            }
        });

        const debounceMap = new Map();
        const setDebounced = (key, fn, delay) => {
            if (debounceMap.has(key)) clearTimeout(debounceMap.get(key));
            debounceMap.set(key, setTimeout(fn, delay));
        };

        const showPendingUI = (item, pendingUntilUnix) => {
            const pendingBox = item.querySelector('[data-cart-pending]');
            const countdown = item.querySelector('[data-cart-countdown]');
            const qty = item.querySelector('[data-cart-qty]');
            const removeBtn = item.querySelector('[data-cart-remove]');
            const cb = item.querySelector('[data-cart-select]');

            if (qty) qty.disabled = true;
            if (removeBtn) removeBtn.disabled = true;
            if (cb) cb.disabled = true;

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
            const U = urls();
            const productId = parseInt(item.getAttribute('data-product-id'), 10);
            const qtyInput = item.querySelector('[data-cart-qty]');
            const removeBtn = item.querySelector('[data-cart-remove]');
            const undoBtn = item.querySelector('[data-cart-undo]');

            const pendingUntil = item.getAttribute('data-pending-until');
            if (pendingUntil) showPendingUI(item, parseInt(pendingUntil, 10));

            if (qtyInput) {
                qtyInput.addEventListener('input', () => {
                    const raw = parseInt(qtyInput.value || '0', 10);
                    const qty = isNaN(raw) ? 0 : raw;

                    setDebounced(`qty:${productId}`, async () => {
                        const json = await postJSON(U.qty, { product_id: productId, qty });
                        if (!json) return;

                        if (json.cart_count !== undefined) setHeaderCartCount(json.cart_count);

                        if (json.pending_remove_until) {
                            showPendingUI(item, parseInt(json.pending_remove_until, 10));
                        }
                    }, 400);
                });
            }

            if (removeBtn) {
                removeBtn.addEventListener('click', async () => {
                    const json = await postJSON(U.remove, { product_id: productId });
                    if (!json) return;
                    if (json.pending_remove_until) {
                        showPendingUI(item, parseInt(json.pending_remove_until, 10));
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

        // checkout
        const checkoutBtn = document.querySelector('[data-cart-checkout]');
        if (checkoutBtn) {
            checkoutBtn.addEventListener('click', async () => {
                const U = urls();
                const json = await postJSON(U.checkout, {});
                if (!json) return;

                if (!json.ok) {
                    alert('Выберите товары для оформления заказа.');
                    return;
                }

                if (json.cart_count !== undefined) setHeaderCartCount(json.cart_count);
                window.location.reload();
            });
        }
    };

    // -----------------------
    // CATALOG PAGE HOOKS
    // -----------------------
    const initCatalog = () => {
        const U = urls();
        const cards = Array.from(document.querySelectorAll('[data-catalog-product]'));
        if (!cards.length) return;

        cards.forEach((card) => {
            const productId = parseInt(card.getAttribute('data-catalog-product'), 10);
            const qtyInput = card.querySelector('[data-catalog-qty]');
            const addBtn = card.querySelector('[data-catalog-add]');
            const inCartBtn = card.querySelector('[data-catalog-incart]');

            // +/- кнопки (важно: генерим input событие)
            card.querySelectorAll('[data-qty-step]').forEach((btn) => {
                btn.addEventListener('click', () => {
                    if (!qtyInput) return;

                    const step = parseInt(btn.getAttribute('data-qty-step') || '0', 10);
                    const current = parseInt(qtyInput.value || '0', 10) || 0;
                    const next = Math.max(0, current + step);

                    qtyInput.value = String(next);
                    qtyInput.dispatchEvent(new Event('input', { bubbles: true }));
                });
            });

            if (qtyInput && (!qtyInput.value || qtyInput.value === '1000')) {
                qtyInput.value = '1';
            }

            if (addBtn) {
                addBtn.addEventListener('click', async () => {
                    const qty = qtyInput ? Math.max(0, parseInt(qtyInput.value || '1', 10) || 1) : 1;
                    const json = await postJSON(U.add, { product_id: productId, qty });
                    if (!json) return;

                    if (json.cart_count !== undefined) setHeaderCartCount(json.cart_count);

                    if (inCartBtn) {
                        addBtn.style.display = 'none';
                        inCartBtn.style.display = '';
                    }
                });
            }

            if (inCartBtn) {
                inCartBtn.addEventListener('click', () => {
                    window.location.href = U.cart;
                });
            }

            // Если уже "в корзине" (кнопка переключилась) и меняют qty — обновляем qty в корзине
            if (qtyInput) {
                let t = null;
                qtyInput.addEventListener('input', () => {
                    if (t) clearTimeout(t);
                    t = setTimeout(async () => {
                        const qty = parseInt(qtyInput.value || '0', 10) || 0;

                        // отправляем qty всегда, но переключаем UI только если ранее уже добавляли
                        const json = await postJSON(U.qty, { product_id: productId, qty });
                        if (!json) return;

                        if (json.cart_count !== undefined) setHeaderCartCount(json.cart_count);

                        if (qty <= 0) {
                            if (addBtn) addBtn.style.display = '';
                            if (inCartBtn) inCartBtn.style.display = 'none';
                            qtyInput.value = '1';
                        }
                    }, 400);
                });
            }
        });
    };

    document.addEventListener('DOMContentLoaded', () => {
        initCartPage();
        initCatalog();
    });
})();
