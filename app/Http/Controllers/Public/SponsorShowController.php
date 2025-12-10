<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PublicSponsor;

class SponsorShowController extends Controller
{
    public function __invoke(PublicSponsor $sponsor)
    {
        return view('public.sponsors.show', compact('sponsor'));
    }
}
