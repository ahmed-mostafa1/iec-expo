<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HallSpaceBooking;
use Illuminate\Http\Request;

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
            'space' => ['required', 'string', 'max:50', 'regex:/^(L\\.W\\.\\d+|R\\.W\\.\\d+)$/i'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        $space = strtoupper($validated['space']);
        $note = $validated['note'] ?? null;

        $booking = HallSpaceBooking::firstOrCreate(['space' => $space], ['note' => $note]);

        if (!$booking->wasRecentlyCreated && $note !== null) {
            $booking->update(['note' => $note]);
        }

        return back()->with('success', __('Space booked successfully.'));
    }

    public function destroy(HallSpaceBooking $hallSpaceBooking)
    {
        $hallSpaceBooking->delete();

        return back()->with('success', __('Space was unbooked.'));
    }
}
