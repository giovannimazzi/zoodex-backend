@props(['entity', 'measure', 'shape'])

@if ($entity && $entity->image)
    <img src="{{ asset('storage/' . $entity->image) }}"
        alt="{{ $entity->name }}"
        style="
            width: {{ $measure }}px;
            height: {{ $measure }}px;
            object-fit: contain;
            border-radius: {{ $shape == 1 ? '50%' : '0%'}};
            background-color: {{ $entity->color }};
        ">
@endif