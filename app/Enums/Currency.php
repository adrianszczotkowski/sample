<?php

namespace App\Enums;

use App\Enums\Traits\ProvidesValues;

enum Currency
{
    use ProvidesValues;

    case PLN;
    case USD;
    case EUR;
    case CHF;
    case GBP;
    case UAH;
}
