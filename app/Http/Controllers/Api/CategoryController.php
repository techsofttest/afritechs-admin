<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private function resolveUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, '/')) {
            return url($path);
        }

        return url('storage/' . $path);
    }

    private function stripTags(?string $content): string
    {
        if (!$content) {
            return '';
        }
        return trim(html_entity_decode(strip_tags($content)));
    }

    public function index(Request $request): JsonResponse
    {
        $categories = Category::all()->map(function ($cat) {
            return [
                'id' => (string) $cat->id,
                'slug' => $cat->slug,
                'name' => $cat->title,
                'title' => $cat->title,
                'img' => $this->resolveUrl($cat->image) ?: '/sectors/export_import.png',
                'image' => $this->resolveUrl($cat->image),
                'is_featured' => (bool) $cat->is_featured,
            ];
        })->values();

        return response()->json([
            'status' => 'success',
            'data' => $categories,
        ]);
    }

    public function megaMenu(Request $request): JsonResponse
    {
        $categories = Category::with(['products' => function ($query) {
            $query->where('is_active', true)->latest()->take(4);
        }])->get();

        $megaMenuData = $categories->map(function ($cat) {
            $products = $cat->products->map(function ($p) {
                return [
                    'id' => (string) $p->id,
                    'slug' => $p->slug,
                    'title' => $p->title,
                    'desc' => $this->stripTags($p->description),
                    'link' => "/products/" . ($p->slug ?: $p->id),
                    'img' => $this->resolveUrl($p->image),
                ];
            })->values();

            return [
                'id' => (string) $cat->id,
                'slug' => $cat->slug,
                'title' => $cat->title,
                'products' => $products,
            ];
        })->values();

        return response()->json([
            'status' => 'success',
            'data' => $megaMenuData,
        ]);
    }
}
