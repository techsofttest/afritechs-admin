<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Data Migration: Copy existing prices and SKUs into default variants
        if (Schema::hasColumn('products', 'price')) {
            $products = DB::table('products')->get();
            foreach ($products as $product) {
                $variantId = DB::table('variants')->insertGetId([
                    'name' => 'Standard',
                    'sku' => $product->sku ?? null,
                    'price' => $product->price ?? 0,
                    'sale_price' => $product->sale_price ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('product_variant')->insert([
                    'product_id' => $product->id,
                    'variant_id' => $variantId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // 2. Drop price, sale_price, sku from products table
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['price', 'sale_price', 'sku']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('sku')->nullable();
            $table->decimal('price', 12, 2)->nullable();
            $table->decimal('sale_price', 12, 2)->nullable();
        });
    }
};
