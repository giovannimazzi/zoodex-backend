<?php

function sortLink($entity, $label, $column, $sort, $direction)
{
    $newDirection = 'asc';

    if ($sort === $column && $direction === 'asc') {
        $newDirection = 'desc';
    }

    $icon = '';

    if ($sort === $column) {
        $icon = $direction === 'asc'
            ? ' ↑'
            : ' ↓';
    }

    $resetSortHtml = '';

    if ($sort === $column && request()->has('sort')) {
        $resetQuery = request()->except(['sort', 'direction', 'page']);
        $resetQuery['page'] = 1;
        $resetUrl = route('admin.'. $entity .'.index', $resetQuery);

        $resetSortHtml = '
            <a href="' . $resetUrl . '"
            class="text-decoration-none text-muted ms-1"
            title="Reset ordinamento"
            aria-label="Reset ordinamento">
                <i class="bi bi-x-circle"></i>
            </a>
        ';
    }

    $url = request()->fullUrlWithQuery([
        'sort' => $column,
        'direction' => $newDirection,
        'page' => 1,
    ]);

    return '
        <span class="d-inline-flex justify-content-center align-items-center w-100">
            <a href="' . $url . '" class="text-decoration-none text-dark">
                ' . $label . $icon . '
            </a>
            ' . $resetSortHtml . '
        </span>
    ';
}