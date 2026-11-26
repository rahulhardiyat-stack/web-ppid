<?php

namespace App\Enums\Concerns;

trait AlurStatus
{
    public function final(): bool
    {
        return $this->bolehKe() === [];
    }

    public static function finalValues(): array
    {
        return array_values(array_map(
            fn (self $c) => $c->value,
            array_filter(self::cases(), fn (self $c) => $c->final())
        ));
    }
}
