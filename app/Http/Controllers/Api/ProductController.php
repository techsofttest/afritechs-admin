<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
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
        $query = Product::where('is_active', true);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('category', function ($cq) use ($search) {
                      $cq->where('title', 'like', "%{$search}%");
                  })
                  ->orWhereHas('variants', function ($vq) use ($search) {
                      $vq->where('name', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('category') && $request->input('category') !== 'all') {
            $cat = $request->input('category');
            $query->where(function ($q) use ($cat) {
                if (is_numeric($cat)) {
                    $q->where('category_id', $cat);
                } else {
                    $q->whereHas('category', function ($cq) use ($cat) {
                        $cq->where('slug', $cat);
                    });
                }
            });
        }

        $products = $query->with(['category', 'variants'])->get()->map(function ($product) {
            $minVariant = $product->variants->sortBy(fn($v) => $v->sale_price ?: $v->price)->first();
            $minPrice = $minVariant ? ($minVariant->sale_price ?: $minVariant->price) : null;
            $formattedPrice = $minPrice ? number_format($minPrice, 0, ',', ' ') . ' €' : 'Sur Devis';

            $variants = $product->variants->map(function ($v) {
                return [
                    'id' => (string) $v->id,
                    'name' => $v->name,
                    'sku' => $v->sku,
                    'price' => (float) $v->price,
                    'sale_price' => $v->sale_price ? (float) $v->sale_price : null,
                    'formattedPrice' => number_format($v->sale_price ?: $v->price, 0, ',', ' ') . ' €',
                ];
            })->values();

            return [
                'id' => (string) $product->id,
                'slug' => $product->slug,
                'title' => $product->title,
                'tag' => $product->category ? $product->category->title : 'Produit',
                'category' => $product->category ? $product->category->slug : 'all',
                'category_id' => (string) $product->category_id,
                'categoryName' => $product->category ? $product->category->title : 'Tous les produits',
                'desc' => $this->stripTags($product->description),
                'img' => $this->resolveUrl($product->image),
                'price' => $formattedPrice,
                'priceValue' => (float) ($minPrice ?: 0),
                'inStock' => (bool) $product->is_active,
                'variants' => $variants,
            ];
        })->values();

        return response()->json([
            'status' => 'success',
            'data' => $products,
        ]);
    }

    public function show($slug_or_id): JsonResponse
    {
        $product = Product::where('is_active', true)
            ->where(function ($query) use ($slug_or_id) {
                if (is_numeric($slug_or_id)) {
                    $query->where('id', $slug_or_id);
                } else {
                    $query->where('slug', $slug_or_id);
                }
            })
            ->with(['category', 'brand', 'variants', 'faqs', 'images', 'specifications'])
            ->first();

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found',
            ], 404);
        }

        // Format Gallery Images
        $galleryImages = [];
        if ($product->image) {
            $galleryImages[] = $this->resolveUrl($product->image);
        }
        foreach ($product->images as $img) {
            if ($img->image) {
                $galleryImages[] = $this->resolveUrl($img->image);
            }
        }

        // Format Specifications
        $specs = $product->specifications->map(function ($s) {
            return [
                'label' => $s->name,
                'value' => $s->value,
            ];
        })->values();

        // Format Faqs
        $faqs = $product->faqs->map(function ($f) {
            return [
                'q' => $f->question ?? $f->title,
                'a' => $this->stripTags($f->answer ?? $f->description),
            ];
        })->values();

        if ($faqs->isEmpty()) {
            $faqs = collect([
                [
                    'q' => 'Comment puis-je obtenir un devis pour ce produit ?',
                    'a' => 'Vous pouvez cliquer sur le bouton "Faire une demande de devis" ou ajouter le produit à votre demande. Notre équipe technico-commerciale vous répondra dans les plus brefs délais.',
                ],
                [
                    'q' => 'Quels sont les délais et modalités de livraison ?',
                    'a' => 'Nous livrons nos équipements et produits dans toute la République de Guinée et la région. Les délais varient selon la disponibilité en stock et la destination.',
                ],
                [
                    'q' => 'Les produits bénéficient-ils d\'une garantie et d\'un service après-vente ?',
                    'a' => 'Oui, tous nos produits et équipements bénéficient d\'une garantie fabricant et d\'un accompagnement technique complet assuré par l\'équipe AFRI TECHS.',
                ],
                [
                    'q' => 'Proposez-vous des pièces de rechange et la maintenance ?',
                    'a' => 'Absolument. Nous fournissons des pièces de rechange d\'origine et proposons des services de maintenance préventive et corrective.',
                ],
            ]);
        }

        // Format Variants
        $variants = $product->variants->map(function ($v) {
            return [
                'id' => (string) $v->id,
                'name' => $v->name,
                'sku' => $v->sku,
                'price' => (float) $v->price,
                'sale_price' => $v->sale_price ? (float) $v->sale_price : null,
                'formattedPrice' => number_format($v->sale_price ?: $v->price, 0, ',', ' ') . ' €',
            ];
        })->values();

        $minVariant = $product->variants->sortBy(fn($v) => $v->sale_price ?: $v->price)->first();
        $minPrice = $minVariant ? ($minVariant->sale_price ?: $minVariant->price) : null;
        $formattedPrice = $minPrice ? number_format($minPrice, 0, ',', ' ') . ' €' : 'Sur Devis';
        $firstSku = $product->variants->first()?->sku ?? '';

        // Fetch related products from same category
        $related = Product::where('is_active', true)
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with(['category', 'variants'])
            ->take(6)
            ->get()
            ->map(function ($p) {
                $pMinVariant = $p->variants->sortBy(fn($v) => $v->sale_price ?: $v->price)->first();
                $pMinPrice = $pMinVariant ? ($pMinVariant->sale_price ?: $pMinVariant->price) : null;
                $pFormattedPrice = $pMinPrice ? number_format($pMinPrice, 0, ',', ' ') . ' €' : 'Sur Devis';

                return [
                    'id' => (string) $p->id,
                    'slug' => $p->slug,
                    'tag' => $p->category ? $p->category->title : 'Produit',
                    'title' => $p->title,
                    'desc' => $this->stripTags($p->description),
                    'img' => $this->resolveUrl($p->image),
                    'price' => $pFormattedPrice,
                    'priceValue' => (float) ($pMinPrice ?: 0),
                    'inStock' => (bool) $p->is_active,
                ];
            })->values();

        $data = [
            'id' => (string) $product->id,
            'slug' => $product->slug,
            'sku' => $firstSku,
            'title' => $product->title,
            'tag' => $product->category ? $product->category->title : 'Produit',
            'categoryName' => $product->category ? $product->category->title : 'Tous les produits',
            'desc' => $this->stripTags($product->description),
            'rawDescription' => $product->description,
            'img' => $this->resolveUrl($product->image),
            'price' => $formattedPrice,
            'priceValue' => (float) ($minPrice ?: 0),
            'inStock' => (bool) $product->is_active,
            'variants' => $variants,
            'galleryImages' => $galleryImages,
            'techSpecs' => $specs,
            'faqs' => $faqs,
            'related' => $related,
        ];

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }
}
