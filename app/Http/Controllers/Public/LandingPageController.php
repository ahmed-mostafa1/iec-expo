<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\AboutContent;
use App\Models\ContactInfo;
use App\Models\HeroMedia;
use App\Models\Participant;
use App\Models\PublicSponsor;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index(Request $request, string $locale)
    {
        $hero = HeroMedia::where('is_active', true)->first();
        $about = AboutContent::query()->first();
        $sponsors = PublicSponsor::where('is_active', true)
            ->orderBy('display_order')
            ->get();
        $participants = Participant::where('is_active', true)
            ->orderBy('display_order')
            ->get();
        $contactInfos = ContactInfo::orderByDesc('is_primary')
            ->orderBy('display_order')
            ->get();

        $scrollToContact = session('scroll_to_contact', false);

        return view('public.landing', compact(
            'hero',
            'about',
            'sponsors',
            'participants',
            'contactInfos',
            'locale',
            'scrollToContact'
        ));
    }
}
