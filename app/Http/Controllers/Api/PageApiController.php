<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use Illuminate\Http\Request;

class PageApiController extends Controller
{
    /**
     * Fetch page content by key (e.g. 'about', 'home')
     */
    public function show(string $key)
    {
        $page = PageContent::where('key', $key)->first();

        if (!$page) {
            return response()->json([
                'status' => 'error',
                'message' => 'Page not found',
            ], 404);
        }

        $content = $page->content ?? [];
        $content = $this->transformImageUrls($content);

        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $page->id,
                'key' => $page->key,
                'title' => $page->title,
                'meta_title' => $page->meta_title,
                'meta_desc' => $page->meta_desc,
                'content' => $content,
            ],
        ]);
    }

    /**
     * Recursively resolve image relative paths into full HTTP URLs
     */
    private function transformImageUrls(mixed $data): mixed
    {
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                if (in_array($k, ['image', 'photo', 'bgImage', 'bg_image']) && is_string($v) && !empty($v)) {
                    $data[$k] = $this->resolveUrl($v);
                } else {
                    $data[$k] = $this->transformImageUrls($v);
                }
            }
        }
        return $data;
    }

    private function resolveUrl(?string $path): string
    {
        if (!$path) {
            return '';
        }
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        return asset(str_starts_with($path, '/') ? ltrim($path, '/') : 'storage/' . $path);
    }
}
