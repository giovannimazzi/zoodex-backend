@props(['entity', 'image' => 'image' , 'measure' => 90, 'fit' => 'contain', 'shape' => 0, 'bgPresent' => 1, 'addClassesString' => ""])

@if ($entity && $entity->$image && Storage::exists($entity->$image))
    <img src="{{ asset('storage/' . $entity->$image) }}"
        alt="{{ $entity->name }}"
        style="
            width: {{ $measure }}px;
            height: {{ $measure }}px;
            object-fit: {{ $fit }};
            border-radius: {{ $shape == 1 ? '50%' : '0%'}};
            @if ($bgPresent == 1)
                background-color: {{ setColor($entity) }};
            @endif
            "
            class="{{ $addClassesString }}";         
        >
@elseif ($entity)
    <span
        class="d-inline-flex justify-content-center align-items-center text-muted {{ $addClassesString }}"
        style="
            width: {{ $measure }}px;
            height: {{ $measure }}px;
            border-radius: {{ $shape == 1 ? '50%' : '0%'}};
            @if ($bgPresent == 1)
                background-color: {{ config('zoodex.fallback_color') }};
            @endif
        "
    ><i class="bi bi-image"></i></span>
@endif