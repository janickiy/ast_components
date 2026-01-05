@if(isset($productIds))
<section class="prev-products">
    <div class="container-md">
        <div class="section-title">
            <h2>Ранее просмотренные товары</h2>
        </div>
        <div class="prev-products-slider swiper">
            <div class="swiper-wrapper">

                @foreach(\App\Models\Products::productsListByIds($productIds) ?? [] as $product)

                <div class="swiper-slide">
                    <article class="prev-product">
                        <div class="prev-product__img">
                            <picture>
                                <img src="{{ $product->getThumbnailUrl() }}" alt="{{ $product->image_alt }}" title="{{ $product->image_title }}" loading="lazy">
                            </picture>
                        </div>
                        <div class="prev-product__title">
                            <h3>{{ $product->title }}</h3>
                        </div>
                        <a href="{{ route('frontend.product',['slug' => $product->slug]) }}" class="prev-product__btn btn btn--secondary">
                            <span>На страницу товара</span>
                            <svg aria-hidden="true">
                                <use xlink:href="{{ url('/images/sprite.svg#arrow-right') }}"></use>
                            </svg>
                        </a>
                    </article>
                </div>

                @endforeach

            </div>
            <div class="swiper-button-prev">
                <svg aria-hidden="true" class="orange">
                    <use xlink:href="{{ url('/images/sprite.svg#chevron-left') }}"></use>
                </svg>
            </div>
            <div class="swiper-button-next">
                <svg aria-hidden="true" class="orange">
                    <use xlink:href="{{ url('/images/sprite.svg#chevron-right') }}"></use>
                </svg>
            </div>
        </div>
    </div>
</section>
@endif
