@if(count($catalogs) > 0)
    <div class="header__subcategory">
        <ul class="header__subcategory-list">
            @foreach($catalogs ?? [] as $catalog)
                <li class="header__subcategory-item">
            <span>
                <a href="{{ route('frontend.catalog', ['slug' => $catalog->slug]) }}">{{ $catalog->name }}</a>
                <sup class="header__item-count">{{ $catalog->getProductCount() }}</sup>
             </span>
                </li>
            @endforeach
        </ul>
    </div>
@else

@endif