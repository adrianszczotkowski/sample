<?php

namespace App\Resolvers\Traits;

trait HandlesData
{
    public function merge(?array $root, ?array $args): array
    {
        return $root
            ? [
                ...$root,
                ...$args
            ]
            : $args;
    }
}
