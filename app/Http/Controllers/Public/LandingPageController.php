<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\LandingSection;
use App\Models\Participant;
use App\Models\Organizer;
use App\Models\PublicSponsor;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index(Request $request, string $locale)
    {
        $heroSection = LandingSection::resolve('hero');
        $registrationSection = LandingSection::resolve('registration');
        $aboutSection = LandingSection::resolve('about');
        $contactSection = LandingSection::resolve('contact');
        $sponsors = PublicSponsor::where('is_active', true)
            ->orderBy('display_order')
            ->get();
        $participants = Participant::where('is_active', true)
            ->orderBy('display_order')
            ->get();
        $organizers = Organizer::where('is_active', true)
            ->orderBy('display_order')
            ->get();

        $scrollToContact = session('scroll_to_contact', false);

        return view('public.landing', compact(
            'heroSection',
            'registrationSection',
            'aboutSection',
            'contactSection',
            'sponsors',
            'participants',
            'organizers',
            'locale',
            'scrollToContact'
        ));
    }
}
