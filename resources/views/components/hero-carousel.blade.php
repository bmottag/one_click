@props([
    'images' => [],   {{-- array de rutas de imágenes --}}
    'height' => 400,
    'id' => 'heroCarousel'
])

<style>
.{{ $id }}-slide {
    background-size: cover;
    background-position: center 60%;
    height: {{ $height }}px;
}

/* Evita zoom excesivo en pantallas grandes */
@media (min-width: 1200px) {
    .{{ $id }}-slide {
        background-size: 100% auto; /* ancho al 100%, altura proporcional */
        background-position: center 60%;
    }
}

/* Tablets */
@media (max-width: 992px) {
    .{{ $id }}-slide {
        background-position: center 50%;
        height: {{ $height - 80 }}px;
    }
}

/* Celulares medianos */
@media (max-width: 768px) {
    .{{ $id }}-slide {
        background-position: left 40%;
        height: {{ $height - 130 }}px;
    }
}

/* Celulares pequeños */
@media (max-width: 480px) {
    .{{ $id }}-slide {
        background-position: left 20%;
        height: {{ $height - 160 }}px;
    }
}

</style>

<div id="{{ $id }}" class="card card-flush carousel slide overflow-hidden" data-bs-ride="carousel" data-bs-interval="5000">

    <div class="carousel-inner">
        @foreach($images as $index => $image)
            <div class="carousel-item @if($index === 0) active @endif">
                <div class="card-header rounded-top {{ $id }}-slide"
                    style="background-image: url('{{ asset($image) }}');">
                </div>
            </div>
        @endforeach
    </div>

    <!-- Indicadores -->
    <div class="card-header position-absolute bottom-0 start-50 translate-middle-x pb-4 z-3">
        <ol class="carousel-indicators carousel-indicators-bullet carousel-indicators-active-primary">
            @foreach($images as $index => $image)
                <li data-bs-target="#{{ $id }}" 
                    data-bs-slide-to="{{ $index }}" 
                    class="@if($index === 0) active @endif ms-1">
                </li>
            @endforeach
        </ol>
    </div>

</div>
