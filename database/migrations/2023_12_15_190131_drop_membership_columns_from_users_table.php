<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $columns = ['api_token', 'last_logged_in_at', 'last_visited_at', 'welcome_valid_until'];

            foreach ($columns as $column) {
                if (in_array($column, $table->getColumns())) {
                    $table->dropColumn($column);
                }
            }

            if (in_array('user_level_id', $table->getColumns())) {
                $table->dropConstrainedForeignId('user_level_id');
            }
        });
    }
};
