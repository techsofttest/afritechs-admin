<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
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
        $query = Project::where('status', true);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhereHas('service', function ($sq) use ($search) {
                      $sq->where('title', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('service') && $request->input('service') !== 'all') {
            $service = $request->input('service');
            $query->where(function ($q) use ($service) {
                if (is_numeric($service)) {
                    $q->where('service_id', $service);
                } else {
                    $q->whereHas('service', function ($sq) use ($service) {
                        $sq->where('slug', $service);
                    });
                }
            });
        }

        $projects = $query->with('service')->latest()->get()->map(function ($p) {
            return [
                'id' => (string) $p->id,
                'slug' => $p->slug,
                'tag' => $p->service ? $p->service->title : 'Projet',
                'title' => $p->title,
                'desc' => $this->stripTags($p->description),
                'location' => $p->location ?? '',
                'img' => $this->resolveUrl($p->image),
            ];
        })->values();

        return response()->json([
            'status' => 'success',
            'data' => $projects,
        ]);
    }

    public function show($slug_or_id): JsonResponse
    {
        $project = Project::where('status', true)
            ->where(function ($query) use ($slug_or_id) {
                if (is_numeric($slug_or_id)) {
                    $query->where('id', $slug_or_id);
                } else {
                    $query->where('slug', $slug_or_id);
                }
            })
            ->with(['service', 'images'])
            ->first();

        if (!$project) {
            return response()->json([
                'status' => 'error',
                'message' => 'Project not found',
            ], 404);
        }

        // Format Gallery Images
        $galleryImages = [];
        if ($project->image) {
            $galleryImages[] = $this->resolveUrl($project->image);
        }
        foreach ($project->images as $img) {
            if ($img->image) {
                $galleryImages[] = $this->resolveUrl($img->image);
            }
        }

        // Related projects from same service or latest
        $related = Project::where('status', true)
            ->where('id', '!=', $project->id)
            ->where('service_id', $project->service_id)
            ->with('service')
            ->take(4)
            ->get()
            ->map(function ($p) {
                return [
                    'id' => (string) $p->id,
                    'slug' => $p->slug,
                    'tag' => $p->service ? $p->service->title : 'Projet',
                    'title' => $p->title,
                    'desc' => $this->stripTags($p->description),
                    'location' => $p->location ?? '',
                    'img' => $this->resolveUrl($p->image),
                ];
            })->values();

        $data = [
            'id' => (string) $project->id,
            'slug' => $project->slug,
            'title' => $project->title,
            'tag' => $project->service ? $project->service->title : 'Projet',
            'serviceName' => $project->service ? $project->service->title : 'Tous les services',
            'location' => $project->location ?? '',
            'desc' => $this->stripTags($project->description),
            'rawDescription' => $project->description,
            'img' => $this->resolveUrl($project->image),
            'galleryImages' => array_values(array_unique($galleryImages)),
            'related' => $related,
        ];

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }
}
