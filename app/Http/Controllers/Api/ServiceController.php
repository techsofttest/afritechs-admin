<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceController extends Controller
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
        $query = Service::where('status', true);

        if ($request->boolean('featured')) {
            $query->where('featured_status', true);
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $services = $query->latest()->get()->map(function ($s) {
            return [
                'id' => (string) $s->id,
                'slug' => $s->slug,
                'title' => $s->title,
                'subtitle' => $this->stripTags($s->description),
                'desc' => $this->stripTags($s->description),
                'image' => $this->resolveUrl($s->image),
                'link' => "/services/{$s->slug}",
            ];
        })->values();

        return response()->json([
            'status' => 'success',
            'data' => $services,
        ]);
    }

    public function show($slug_or_id): JsonResponse
    {
        $service = Service::where('status', true)
            ->where(function ($query) use ($slug_or_id) {
                if (is_numeric($slug_or_id)) {
                    $query->where('id', $slug_or_id);
                } else {
                    $query->where('slug', $slug_or_id);
                }
            })
            ->with(['projects' => function ($q) {
                $q->where('status', true)->latest()->take(6);
            }])
            ->first();

        if (!$service) {
            return response()->json([
                'status' => 'error',
                'message' => 'Service not found',
            ], 404);
        }

        $projects = $service->projects->map(function ($p) use ($service) {
            return [
                'id' => (string) $p->id,
                'slug' => $p->slug,
                'tag' => $service->title,
                'title' => $p->title,
                'desc' => $this->stripTags($p->description),
                'location' => $p->location ?? '',
                'img' => $this->resolveUrl($p->image),
            ];
        })->values();

        $data = [
            'id' => (string) $service->id,
            'slug' => $service->slug,
            'title' => $service->title,
            'subtitle' => $this->stripTags($service->description),
            'desc' => $this->stripTags($service->description),
            'rawDescription' => $service->description,
            'image' => $this->resolveUrl($service->image),
            'benefits' => [
                "Équipements et solutions de haute technicité",
                "Accompagnement et ingénierie de projet sur-mesure",
                "Service après-vente et maintenance préventive locale",
                "Conformité avec les normes internationales de sécurité"
            ],
            'projects' => $projects,
        ];

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }
}
