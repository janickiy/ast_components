{!! Form::open(['url' => route('frontend.catalog', $catalog ? ['slug' => $catalog->slug] : []), 'method' => 'get']) !!}

<div class="catalog__filters-accordions accordions">
    <div class="accordion__item">
        <button class="catalog__accordion-btn accordion__btn js-accordion-btn" aria-expanded="true">
            <span class="accordion__title">Товарная группа</span>
            <svg aria-hidden="true" class="orange">
                <use xlink:href="{{ url('/images/sprite.svg#chevron-down') }}"></use>
            </svg>
        </button>
        @php
            $isFilter = (request()->has('catalog_id') ||
            request()->has('manufacturer_id') ||
            request()->has('under_order') ||
            request()->has('in_stock')) === true;
        @endphp
        <div class="accordion__content">
            <div class="catalog__filters-list">
                @if($filterCatalogs->count() > 0)
                @foreach($filterCatalogs ?? [] as $filterCatalog)
                <div class="catalog__filters-checkbox form-checkbox">
                    @php
                        $cbId = 'category-' . $filterCatalog->id;
                        $isChecked = request()->has('catalog_id') ? in_array($filterCatalog->id, request()->get('catalog_id')) : ($isFilter ? 0:1);
                   @endphp
                   {!! Form::checkbox('catalog_id[]', $filterCatalog->id, $isChecked, ['id' => $cbId]) !!}
                   <label for="catalog_id[]">
                       <span>{{ $filterCatalog->name }}</span>
                       <sup class="catalog__item-count">{{ $filterCatalog->getTotalProductCount() }}</sup>
                   </label>
                </div>
                @endforeach
                @else
                    <p style="padding: 1rem;">Нет доступных категорий</p>
                @endif
            </div>
        </div>
    </div>

    <div class="accordion__item">
        <button class="catalog__accordion-btn accordion__btn js-accordion-btn" aria-expanded="true">
            <span class="accordion__title">Наличие</span>
            <svg aria-hidden="true" class="orange">
                <use xlink:href="{{ url('/images/sprite.svg#chevron-down') }}"></use>
            </svg>
        </button>

        <div class="accordion__content">
            <div class="catalog__filters-list">
                @php
                    $inStockChecked = request()->get('in_stock') == 1;
                    $underOrderChecked = request()->get('under_order') == 1;
                @endphp
                <div class="catalog__filters-checkbox form-checkbox">
                    {!! Form::checkbox('in_stock', 1, $isFilter ? $inStockChecked : 1) !!}
                    <label for="in_stock">
                        <span>В наличии</span>
                        <sup class="catalog__item-count">{{ $inStockCount ?? 0 }}</sup>
                    </label>
                </div>
                <div class="catalog__filters-checkbox form-checkbox">
                    {!! Form::checkbox('under_order', 1, $isFilter ? $underOrderChecked : 1) !!}
                    <label for="under_order">
                        <span>Под заказ</span>
                        <sup class="catalog__item-count">{{ $underOrder ?? 0 }}</sup>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="accordion__item">
        <button class="catalog__accordion-btn accordion__btn js-accordion-btn" aria-expanded="true">
            <span class="accordion__title">Бренд</span>
            <svg aria-hidden="true" class="orange">
                <use xlink:href="{{ url('/images/sprite.svg#chevron-down') }}"></use>
            </svg>
        </button>
        <div class="accordion__content">
            <div class="catalog__filters-list">
                @foreach(($manufacturers ?? []) as $manufacturer)
                    @php
                        $cbId = 'brand-' . $manufacturer->id;
                        $isChecked = request()->has('manufacturer_id') ? in_array($manufacturer->id, request()->get('manufacturer_id')) : ($isFilter ? 0:1);
                    @endphp
                    <div class="catalog__filters-checkbox form-checkbox">
                        {!! Form::checkbox('manufacturer_id[]', $manufacturer->id, $isChecked, ['id' => $cbId]) !!}
                        <label for="{{ $cbId }}">
                            <span>{{ $manufacturer->title }}</span>
                            <sup class="catalog__item-count">{{ $manufacturer->getProductCount($catalogIds) }}</sup>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<button type="submit" class="catalog__apply-btn btn btn--tertiary js-catalog-apply-btn">
    <span>Применить</span>
</button>

{!! Form::close() !!}
