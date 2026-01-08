<div class="page-header container-lg">
    <div class="page-header__wrap">
        <ul class="breadcrumbs">
            <li><a href="{{ url('/') }}" class="breadcrumbs-item">Главная</a></li>

            @foreach($breadcrumbs ?? [] as $breadcrumb)
                <li><a href="{{ $breadcrumb['url'] }}" class="breadcrumbs-item">{{ $breadcrumb['title'] }}</a></li>
            @endforeach

            <li><span class="breadcrumbs-item">{{ $title }}</span></li>
        </ul>
        <h1>{{ $h1 }}</h1>
    </div>
</div>