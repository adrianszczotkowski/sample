<?php

use App\Commons\Database\ConstantsPool as D;
use App\Enums\TableNames as T;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable(T::bookings->name)) {
            Schema::create(
                T::bookings->name,
                static function (Blueprint $table) {
                    $table->id();
                    $table->timestamps();
                    $table->softDeletes();

                    $table->unsignedBigInteger(D::USER_ID);
                    $table
                        ->foreign(D::USER_ID)
                        ->references(D::ID)
                        ->on(T::users->name);

                    $table->unsignedBigInteger(D::BOOKING_ITEM_ID);
                    $table
                        ->foreign(D::BOOKING_ITEM_ID)
                        ->references(D::ID)
                        ->on(T::booking_items->name);

                    $table->date(D::BOOKING_DAY);
                });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists(T::bookings->name);
    }
};
