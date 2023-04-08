<?php

declare(strict_types=1);

use App\Modules\Recipe\Models\RecipeFeature;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $features = ['Dairy Free', 'Egg Free', 'Nut Free', 'Soya Free', 'Alcohol Free'];

        foreach ($features as $feature) {
            /** @var RecipeFeature $feature */
            $feature = RecipeFeature::query()->firstWhere('feature', $feature);

            if ( ! $feature) {
                continue;
            }

            DB::delete('delete from recipe_assigned_features where feature_type_id = ?', [$feature->id]);

            $feature->delete();
        }
    }
};
