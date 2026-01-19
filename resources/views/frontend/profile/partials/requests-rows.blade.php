@foreach($requests ?? [] as $request)
    <tr>
        <td>{{ $request->id }}</td>
        <td class="text-right">{{ $request->created_at->format('d.m.Y') }}</td>
        <td>{{ $request->nomenclature }}</td>
        <td class="text-medium text-right">{{ $request->count }}</td>
        <td>
            <div class="account__table-status {{ $request->getStatus()?->cssClass() }}">
                <svg>
                    <use xlink:href="images/sprite.svg#{{ $request->getStatus()?->statusIcon() }}"></use>
                </svg>
                <span>{{ $request->getStatus()?->label() }}</span>
            </div>
        </td>
    </tr>
@endforeach
