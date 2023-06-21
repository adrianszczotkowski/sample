<?php

use App\Commons\Database\ConstantsPool as D;
use App\Enums\TableNames as T;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable(T::users->name)) {
            Schema::create(
                T::users->name,
                static function (Blueprint $table) {
                    $table->id();
                    $table->string(D::NAME);
                    $table
                        ->string(D::EMAIL)
                        ->unique();
                    $table
                        ->timestamp(D::EMAIL_VERIFIED_AT)
                        ->nullable();
                    $table->string(D::PASSWORD);
                    $table->rememberToken();
                    $table->timestamps();
                });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists(T::users->name);
    }
};
