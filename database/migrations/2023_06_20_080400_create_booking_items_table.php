<?php

use App\Commons\Database\ConstantsPool as D;
use App\Enums\Currency;
use App\Enums\TableNames as T;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable(T::booking_items->name)) {
            Schema::create(
                T::booking_items->name,
                static function (Blueprint $table) {
                    $table->id();
                    $table->timestamps();
                    $table->softDeletes();

                    $table
                        ->string(D::NAME)
                        ->unique()
                        ->index();

                    $table->integer(D::BED_COUNT);
                    $table->integer(D::AREA);
                    $table->unsignedBigInteger(D::PRICE);

                    $table
                        ->enum(D::CURRENCY, Currency::names())
                        ->default(Currency::PLN->name)
                        ->index();
                });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists(T::booking_items->name);
    }
};
