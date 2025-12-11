<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PublicSponsor;
use Illuminate\Support\Carbon;

class SponsorShowController extends Controller
{
    public function __invoke(string $sponsor)
    {
        $sponsorModel = null;

        try {
            $sponsorModel = PublicSponsor::find($sponsor);
        } catch (\Throwable $e) {
            report($e);
        }

        if (! $sponsorModel) {
            $demoSponsors = config('demo.sponsors', []);
            $demo = $demoSponsors[$sponsor] ?? $demoSponsors[(int) $sponsor] ?? null;

            if (! $demo) {
                abort(404);
            }

            $sponsorModel = new PublicSponsor($demo);
            $sponsorModel->id = $sponsor;
            $sponsorModel->exists = false;
            $sponsorModel->created_at = Carbon::now();
            $sponsorModel->updated_at = Carbon::now();
        }

        return view('public.sponsors.show', ['sponsor' => $sponsorModel]);
    }
}
