<?php

namespace App\Enums\Traits;

use App\Commons\ConstantsPool as P;
use App\Commons\Database\ConstantsPool as D;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait ProvidesValues
{
    public static function values(): array
    {
        $class = Str::of(self::class)
            ->explode(P::BACKSLASHES)
            ->last();

        $values = [
            D::NAME => $class
        ];
        $cases = [];

        foreach (static::cases() as $case) {
            $cases[$case->name] = [
                P::VALUE => $case->name,
                P::DESCRIPTION => $case->value ?? null
            ];
        }

        $values[P::VALUES] = collect($cases)
            ->sortBy(P::DESCRIPTION)
            ->toArray();

        return $values;
    }

    public static function names(): array
    {
        return Arr::pluck(
            static::cases(),
            D::NAME
        );
    }

    public static function valueOf(string $value): string
    {
        return self::match($value)->value;
    }

    public static function nameOf(string $value): string
    {
        return self::match($value)->name;
    }

    private static function match(string $value): mixed
    {
        return Arr::first(
            static::cases(),
            static fn($v) => $v->name === $value
        );
    }
}
