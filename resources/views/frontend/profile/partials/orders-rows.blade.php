@foreach($orders ?? [] as $order)
    <tr>
        <td>
            <div class="account__table-numb">
                <span>{{ $order->id }}</span>
                <button type="button"
                        class="btn btn--secondary btn--sm btn--icon js-order-details-btn"

                        data-order-id="{{ $order->id }}"
                >
                    <span class="sr-only">{{ __('Детали заказа') }}</span>
                    <svg aria-hidden="true">
                        <use xlink:href="{{ url('/images/sprite.svg#details') }}"></use>
                    </svg>
                </button>
            </div>

            <template id="order-items-{{ $order->id }}">
                <ul class="order-list">
                    @foreach($order->items as $item)
                        @php($p = $item->product)
                        <li class="order-list__item">
                            <div class="order-list__item-img">
                                <picture>
                                    <img src="{{ $p?->getThumbnailUrl() }}"
                                         title="{{ $p?->image_title }}"
                                         alt="{{ $p->image_alt ?? $p->title }}">
                                </picture>
                            </div>
                            <div class="order-list__item-info">
                                <a href="{{ route('frontend.product', ['slug' => $p->slug]) }}"
                                   target="_blank"
                                   class="order-list__item-title">
                                    {{ $p?->title ?? ($p->product_info ?? __('Товар')) }}
                                </a>
                                <span class="order-list__item-count">
                                    {{ __('Количество') }}: {{ $item->count }}
                                </span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </template>
        </td>

        <td class="text-right">{{ $order->dateFormat() }}</td>
        <td class="text-nowrap">{{ MoneyFormatterHelper::format((int)$order->sum()) }}</td>
        <td>{{ $order->deliveryDateFormat() }}</td>

        <td>
            <div class="account__table-status {{ $order->getStatus()?->cssClass() }}">
                <svg aria-hidden="true">
                    <use xlink:href="{{ url('/images/sprite.svg#') }}{{ $order->getStatus()?->statusIcon() }}"></use>
                </svg>
                <span>{{ $order->getStatus()?->label() }}</span>
            </div>
        </td>

        <td>
            @if($order->invoice)
                <a target="_blank" href="{{ $order->getInvoice() }}" class="btn btn--secondary btn--sm">
                    <svg aria-hidden="true">
                        <use xlink:href="{{ url('/images/sprite.svg#downlo') }}ad"></use>
                    </svg>
                    <span>Скачать счёт</span>
                </a>
            @endif
        </td>
    </tr>
@endforeach
