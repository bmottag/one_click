@props(['items' => []])

<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
    @foreach ($items as $item)
        @if (!$loop->first)
            <!-- Bullet -->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
        @endif

        <li class="breadcrumb-item text-muted">
            @if(isset($item['url']))
                <a href="{{ $item['url'] }}" class="text-muted text-hover-primary">{{ $item['label'] }}</a>
            @else
                {{ $item['label'] }}
            @endif
        </li>
    @endforeach
</ul>
