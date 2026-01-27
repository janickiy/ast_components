@forelse($complaints ?? [] as $complaint)
    <tr class="account__item js-account-item" data-list="claims">
        <td>{{ $complaintTypes[$complaint->type] ?? '—' }}</td>
        <td>№{{ $complaint->order_id }} от {{ $complaint->order?->created_at?->format('d.m.Y') }}</td>
        <td>
            <div class="account__table-product tooltip js-account-tooltip">
                <div class="tooltip__body js-account-tooltip-tbody" role="tooltip">
                    <span>{{ $complaint->product?->title ?? '—' }}</span>
                </div>
                <span class="account__table-title js-account-tooltip-title">{{ $complaint->product?->title ?? '—' }}</span>
            </div>
        </td>
        <td class="text-medium text-nowrap text-right">{{ number_format((int) $complaint->order_count, 0, '', ' ') }}</td>
        <td class="account__table-defect-count">{{ number_format((int) $complaint->return_count, 0, '', ' ') }}</td>
        <td>
            <div class="account__table-status {{ $complaint->getStatus()?->cssClass() ?? 'in-progress' }}">
                <svg aria-hidden="true">
                    <use xlink:href="{{ url('/images/sprite.svg#' . $complaint->getStatus()?->statusIcon() ?? 'cogwheel') }}"></use>
                </svg>
                <span>{{ $complaint->getStatus()?->label() ?? 'В обработке' }}</span>
            </div>
        </td>
        <td class="account__table-result"></td>
        <td class="text-center">—</td>
        <td class="text-center">—</td>
    </tr>
@empty
    <tr>
        <td colspan="9" class="text-center">Претензий пока нет</td>
    </tr>
@endforelse
