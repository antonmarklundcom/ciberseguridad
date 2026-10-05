<?php
declare(strict_types=1);
function site_pages(): array {
    static $pages;
    return $pages ??= json_decode(file_get_contents(__DIR__ . '/page-data.json'), true, 512, JSON_THROW_ON_ERROR);
}
function site_page(string $slug): array {
    $pages=site_pages();
    if (!isset($pages[$slug])) throw new InvalidArgumentException('Unknown page');
    return $pages[$slug] + ['slug'=>$slug];
}
function page_path(string $slug): string { return $slug === '' ? '/' : '/' . $slug . '/'; }
