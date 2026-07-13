<?php

namespace App\Services;

use App\Models\HallSpaceBooking;
use App\Models\IconPlusRegistration;
use App\Models\IconRegistration;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class HallSpaceService
{
    /**
     * @var array<string, array{0: int, 1: int}>
     */
    private const RANGES = [
        'icon-plus' => [1, 28],
        'icon' => [29, 112],
        'icon-plus-quartet' => [1, 56],
        'icon-quartet' => [57, 112],
    ];

    public static function normalize(?string $space): ?string
    {
        if ($space === null) {
            return null;
        }

        $normalized = strtoupper(trim($space));

        return $normalized === '' ? null : $normalized;
    }

    /**
     * @return array<int, string>
     */
    public static function allowedSpaces(string $target): array
    {
        [$start, $end] = self::RANGES[$target] ?? self::RANGES['icon'];

        $spaces = [];
        foreach (['L.W.', 'R.W.'] as $prefix) {
            for ($number = $start; $number <= $end; $number++) {
                $spaces[] = "{$prefix}{$number}";
            }
        }

        if ($target === 'icon') {
            array_push($spaces, 'CZ1', 'CZ2', 'CZ3', 'CZ4');
        }

        return $spaces;
    }

    /**
     * Returns the 4 space names for the 2x2 cluster containing $space
     * (matches the geometry generateAisle() draws in hall-design.blade.php),
     * or [] if $space isn't a valid L.W./R.W. member.
     *
     * @return array<int, string>
     */
    public static function quartetFor(string $space): array
    {
        $normalized = self::normalize($space);

        if ($normalized === null || ! preg_match('/^([LR]\.W\.)(\d{1,3})$/', $normalized, $matches)) {
            return [];
        }

        $prefix = $matches[1];
        $number = (int) $matches[2];

        $blockStart = match (true) {
            $number >= 1 && $number <= 56 => 1,
            $number >= 57 && $number <= 112 => 57,
            default => null,
        };

        if ($blockStart === null) {
            return [];
        }

        $lowStart = $blockStart;
        $highStart = $blockStart + 28;
        $anchor = $number >= $highStart ? $highStart : $lowStart;
        $i = intdiv($number - $anchor, 2);

        $low = $lowStart + 2 * $i;
        $high = $highStart + 2 * $i;

        return [
            "{$prefix}{$low}",
            "{$prefix}".($low + 1),
            "{$prefix}{$high}",
            "{$prefix}".($high + 1),
        ];
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
