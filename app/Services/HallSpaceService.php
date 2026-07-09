<?php

namespace App\Services;

use App\Models\HallSpaceBooking;
use App\Models\IconPlusRegistration;
use App\Models\IconRegistration;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class HallSpaceService
{
    public static function normalize(?string $space): ?string
    {
        if ($space === null) {
            return null;
        }

        $normalized = strtoupper(trim($space));

        return $normalized === '' ? null : $normalized;
    }

    public static function isIconPlusSpace(?string $space): bool
    {
        $normalized = self::normalize($space);

        if ($normalized === null) {
            return false;
        }

        return (bool) preg_match('/^[LR]\.W\.(?:[1-9]|1\d|2[0-8])$/', $normalized);
    }

    public static function isOccupied(?string $space): bool
    {
        $normalized = self::normalize($space);

        if ($normalized === null) {
            return false;
        }

        return in_array($normalized, self::occupiedSpaces(), true);
    }

    /**
     * @return array<int, string>
     */
    public static function occupiedSpaces(): array
    {
        return self::spaceCollection([
            ...self::manualHeldSpaces(),
        ])->values()->all();
    }

    /**
     * @return array<int, string>
     */
    public static function iconPlusSpaces(): array
    {
        $spaces = [];

        foreach (['L.W.', 'R.W.'] as $prefix) {
            for ($number = 1; $number <= 28; $number++) {
                $spaces[] = "{$prefix}{$number}";
            }
        }

        return $spaces;
    }

    /**
     * @param  array<int, string|null>  $spaces
     * @return Collection<int, string>
     */
    private static function spaceCollection(array $spaces): Collection
    {
        return collect($spaces)
            ->map(fn (?string $space): ?string => self::normalize($space))
            ->filter()
            ->unique()
            ->values();
    }

    /**
     * @return array<int, string|null>
     */
    private static function manualHeldSpaces(): array
    {
        return HallSpaceBooking::query()
            ->pluck('space')
            ->all();
    }

    /**
     * @return array<int, string|null>
     */
    private static function iconRegistrationSpaces(): array
    {
        return IconRegistration::query()
            ->whereNotNull('location_selection')
            ->pluck('location_selection')
            ->all();
    }

    /**
     * @return array<int, string|null>
     */
    private static function iconPlusRegistrationSpaces(): array
    {
        if (! Schema::hasTable('icon_plus_registrations')) {
            return [];
        }

        return IconPlusRegistration::query()
            ->whereNotNull('location_selection')
            ->pluck('location_selection')
            ->all();
    }
}
