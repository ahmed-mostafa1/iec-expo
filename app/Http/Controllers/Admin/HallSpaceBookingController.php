<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HallSpaceBooking;
use App\Services\HallSpaceService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class HallSpaceBookingController extends Controller
{
    public function index()
    {
        $manualBookings = HallSpaceBooking::orderBy('space')->get();
        $bookedSpaces = $manualBookings->pluck('space')
            ->filter()
            ->map(fn ($space) => strtoupper($space))
            ->unique()
            ->sort()
            ->values();

        return view('admin.hall-spaces.index', [
            'manualBookings' => $manualBookings,
            'bookedSpaces' => $bookedSpaces,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'space' => ['required', 'string', 'max:50', 'regex:/^(L\\.W\\.\\d+|R\\.W\\.\\d+|CZ\\d+)$/i'],
            'note' => ['nullable', 'string', 'max:255'],
            'is_quartet' => ['nullable', 'boolean'],
        ]);

        $space = strtoupper($validated['space']);
        $note = $validated['note'] ?? null;
        $spaces = [$space];

        if ($request->boolean('is_quartet')) {
            $quartet = HallSpaceService::quartetFor($space);

            if ($quartet === []) {
                throw ValidationException::withMessages([
                    'space' => __('This space code has no quartet group (only L.W./R.W. spaces can be booked as a quartet).'),
                ]);
            }

            $spaces = $quartet;
        }

        foreach ($spaces as $spaceCode) {
            $booking = HallSpaceBooking::firstOrCreate(['space' => $spaceCode], ['note' => $note]);

            if (!$booking->wasRecentlyCreated && $note !== null) {
                $booking->update(['note' => $note]);
            }
        }

        return back()->with('success', __(count($spaces) > 1 ? 'Quartet booked successfully.' : 'Space booked successfully.'));
    }

    public function destroy(HallSpaceBooking $hallSpaceBooking)
    {
        $hallSpaceBooking->delete();

        return back()->with('success', __('Space was unbooked.'));
    }
}
