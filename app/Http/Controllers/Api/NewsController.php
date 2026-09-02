<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\JsonResponse;

class NewsController extends Controller
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

    public function index(): JsonResponse
    {
        $news = News::where('status', true)
            ->latest()
            ->get()
            ->map(function ($item) {
                return [
                    'id' => (string) $item->id,
                    'slug' => $item->slug,
                    'title' => $item->title,
                    'shortDesc' => $this->stripTags($item->description),
                    'longDesc' => $item->description,
                    'image' => $this->resolveUrl($item->image),
                    'date' => $item->created_at ? $item->created_at->format('d/m/Y') : '',
                    'author' => 'AFRI TECHS',
                    'category' => 'Actualités',
                ];
            })->values();

        return response()->json([
            'status' => 'success',
            'data' => $news,
        ]);
    }

    public function show($slug_or_id): JsonResponse
    {
        $item = News::where('status', true)
            ->where(function ($query) use ($slug_or_id) {
                if (is_numeric($slug_or_id)) {
                    $query->where('id', $slug_or_id);
                } else {
                    $query->where('slug', $slug_or_id);
                }
            })
            ->first();

        if (!$item) {
            return response()->json([
                'status' => 'error',
                'message' => 'News article not found',
            ], 404);
        }

        // Related news items
        $related = News::where('status', true)
            ->where('id', '!=', $item->id)
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($rel) {
                return [
                    'id' => (string) $rel->id,
                    'slug' => $rel->slug,
                    'title' => $rel->title,
                    'shortDesc' => $this->stripTags($rel->description),
                    'image' => $this->resolveUrl($rel->image),
                    'date' => $rel->created_at ? $rel->created_at->format('d/m/Y') : '',
                    'author' => 'AFRI TECHS',
                    'category' => 'Actualités',
                ];
            })->values();

        $data = [
            'id' => (string) $item->id,
            'slug' => $item->slug,
            'title' => $item->title,
            'subtitle' => $this->stripTags($item->description),
            'shortDesc' => $this->stripTags($item->description),
            'longDesc' => $item->description,
            'image' => $this->resolveUrl($item->image),
            'date' => $item->created_at ? $item->created_at->format('d/m/Y') : '',
            'author' => 'AFRI TECHS',
            'category' => 'Actualités',
            'benefits' => [
                "Information certifiée et actualisée",
                "Couverture complète des secteurs clés",
                "Expertise technique locale et internationale",
                "Analyse des opportunités et des marchés"
            ],
            'features' => [
                "Actualités des secteurs clés de l'agro-industrie",
                "Innovations technologiques et énergétiques",
                "Développements régionaux et opportunités d'affaires",
                "Accompagnement et conseils d'experts"
            ],
            'related' => $related,
        ];

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }
}
