<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\HeroSlider;
use App\Models\News;
use App\Models\Product;
use App\Models\Project;
use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    /**
     * Helper to resolve relative media paths to absolute URLs.
     */
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

    /**
     * Clean rich text HTML tags for brief descriptions.
     */
    private function stripTags(?string $content): string
    {
        if (!$content) {
            return '';
        }
        return trim(html_entity_decode(strip_tags($content)));
    }

    public function index(): JsonResponse
    {
        // 1. Hero Sliders
        $heroSliders = HeroSlider::where('status', true)
            ->get()
            ->map(function ($slide) {
                return [
                    'id' => $slide->id,
                    'title' => $slide->title,
                    'desc' => $this->stripTags($slide->description),
                    'img' => $this->resolveUrl($slide->image),
                ];
            });

        // 2. Sectors (Categories)
        $sectors = Category::all()->map(function ($cat) {
            return [
                'id' => $cat->id,
                'title' => $cat->title,
                'slug' => $cat->slug,
                'img' => $this->resolveUrl($cat->image),
            ];
        });

        // 3. Featured Categories with associated products
        $featuredCategories = Category::where('is_featured', true)
            ->with(['products' => function ($query) {
                $query->where('is_active', true)->with('variants')->take(10);
            }])
            ->get()
            ->map(function ($cat) {
                return [
                    'id' => $cat->id,
                    'title' => $cat->title,
                    'slug' => $cat->slug,
                    'products' => $cat->products->map(function ($product) use ($cat) {
                        $minVariant = $product->variants->sortBy(fn($v) => $v->sale_price ?: $v->price)->first();
                        $minPrice = $minVariant ? ($minVariant->sale_price ?: $minVariant->price) : null;
                        $formattedPrice = $minPrice ? number_format($minPrice, 0, ',', ' ') . ' €' : 'Sur Devis';

                        return [
                            'id' => (string) $product->id,
                            'slug' => $product->slug,
                            'tag' => $cat->title,
                            'title' => $product->title,
                            'desc' => $this->stripTags($product->description),
                            'img' => $this->resolveUrl($product->image),
                            'price' => $formattedPrice,
                            'priceValue' => (float) ($minPrice ?: 0),
                            'inStock' => (bool) $product->is_active,
                        ];
                    })->values(),
                ];
            });

        // 4. Flagship Products
        $flagshipProducts = Product::where('is_active', true)
            ->where('is_flagship', true)
            ->with(['category', 'variants'])
            ->get()
            ->map(function ($product) {
                $minVariant = $product->variants->sortBy(fn($v) => $v->sale_price ?: $v->price)->first();
                $minPrice = $minVariant ? ($minVariant->sale_price ?: $minVariant->price) : null;
                $formattedPrice = $minPrice ? number_format($minPrice, 0, ',', ' ') . ' €' : 'Sur Devis';

                return [
                    'id' => (string) $product->id,
                    'slug' => $product->slug,
                    'tag' => $product->category ? $product->category->title : 'Solutions',
                    'title' => $product->title,
                    'desc' => $this->stripTags($product->description),
                    'img' => $this->resolveUrl($product->image),
                    'price' => $formattedPrice,
                    'priceValue' => (float) ($minPrice ?: 0),
                    'inStock' => (bool) $product->is_active,
                ];
            });

        // 5. Flagship Projects
        $flagshipProjects = Project::where('status', true)
            ->where('is_flagship', true)
            ->with('service')
            ->get()
            ->map(function ($project) {
                return [
                    'id' => (string) $project->id,
                    'slug' => $project->slug,
                    'tag' => $project->service ? $project->service->title : 'Projet',
                    'title' => $project->title,
                    'desc' => $this->stripTags($project->description),
                    'location' => $project->location ?? '',
                    'img' => $this->resolveUrl($project->image),
                ];
            });

        // 6. News & Developments
        $news = News::where('status', true)
            ->latest()
            ->take(4)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => (string) $item->id,
                    'slug' => $item->slug,
                    'title' => $item->title,
                    'shortDesc' => $this->stripTags($item->description),
                    'image' => $this->resolveUrl($item->image),
                    'date' => $item->created_at ? $item->created_at->format('d/m/Y') : '',
                    'author' => 'AFRI TECHS',
                    'category' => 'Actualités',
                ];
            });

        // 7. Dynamic Banners
        $banners = Banner::all()->map(function ($b) {
            return [
                'id' => (string) $b->id,
                'page' => $b->page,
                'title' => $b->title,
                'desc' => $this->stripTags($b->description),
                'img' => $this->resolveUrl($b->image),
            ];
        });

        // 8. Testimonials
        $testimonials = \App\Models\Testimonial::all()->map(function ($t) {
            $nameParts = array_filter(explode(' ', trim($t->name)));
            $initials = '';
            foreach ($nameParts as $part) {
                $initials .= mb_substr($part, 0, 1);
            }
            $initials = mb_strtoupper(mb_substr($initials, 0, 2));

            return [
                'id' => (string) $t->id,
                'name' => $t->name,
                'text' => $this->stripTags($t->description),
                'image' => $this->resolveUrl($t->image),
                'initials' => $initials ?: 'AT',
            ];
        });

        return response()->json([
            'heroSliders' => $heroSliders,
            'sectors' => $sectors,
            'featuredCategories' => $featuredCategories,
            'flagshipProducts' => $flagshipProducts,
            'flagshipProjects' => $flagshipProjects,
            'news' => $news,
            'banners' => $banners,
            'testimonials' => $testimonials,
        ]);
    }
}
