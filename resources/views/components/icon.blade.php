@props(['entity', 'measure', 'shape'])

@if ($entity && $entity->image)
    <img src="{{ asset('storage/' . $entity->image) }}"
        alt="{{ $entity->name }}"
        style="
            width: {{ $measure }}px;
            height: {{ $measure }}px;
            object-fit: contain;
            border-radius: {{ $shape == 1 ? '50%' : '0%'}};
            background-color: {{ !empty($entity->color) ? $entity->color : config('zoodex.fallback_color') }};
        ">
@elseif ($entity)
    <span
        class="d-inline-flex justify-content-center align-items-center text-muted"
        style="
            width: {{ $measure }}px;
            height: {{ $measure }}px;
            border-radius: {{ $shape == 1 ? '50%' : '0%'}};
            background-color: #e9ecef;
        "
    ><i class="bi bi-image"></i></span>
@endif