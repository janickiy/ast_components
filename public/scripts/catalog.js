(function () {
    'use strict';

    function initSubCatalog() {
        const result = document.getElementById('sub-category-menu');

        document.body.addEventListener('mouseover', async (e) => {
            if (e.target.classList.contains("category-item")) {
                let dataId = e.target.getAttribute('data-id');
                document.getElementById("sub-category-menu").innerHTML = "";

                try {
                    const res = await fetch(buildAjaxUrl(dataId), {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                        credentials: 'same-origin',
                    });

                    if (!res.ok) {
                        console.error('Orders AJAX failed:', res.status, await res.text());
                        document.getElementById("sub-category-menu").innerHTML = "";
                        return;
                    }

                    const data = await res.json();

                    result.insertAdjacentHTML('beforeend', data.html);

                } catch (e) {
                    console.error('Orders AJAX error:', e);
                }
            }
        });

        function buildAjaxUrl(dataId) {
            const url = new URL('/sub-catalogs/' + dataId, window.location.origin);
            return url.toString();
        }
    }

    // Запускаем после загрузки DOM
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSubCatalog);
    } else {
        initSubCatalog();
    }
})();

