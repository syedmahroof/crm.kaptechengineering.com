<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Product;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('name');
        });

        Product::withTrashed()
            ->select('id', 'name', 'slug')
            ->chunkById(100, function ($products) {
                foreach ($products as $product) {
                    if (!empty($product->slug)) {
                        continue;
                    }

                    $product->slug = $this->generateUniqueSlug($product->name, $product->id);
                    $product->saveQuietly();
                }
            });

        Schema::table('products', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('products', 'slug')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropUnique('products_slug_unique');
                $table->dropColumn('slug');
            });
        }
    }

    private function generateUniqueSlug(?string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name ?? '') ?: 'product';
        $slug = $baseSlug;
        $counter = 1;

        while (
            Product::withTrashed()
                ->where('slug', $slug)
                ->when($ignoreId, function ($query, $ignoreId) {
                    return $query->where('id', '!=', $ignoreId);
                })
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
};
