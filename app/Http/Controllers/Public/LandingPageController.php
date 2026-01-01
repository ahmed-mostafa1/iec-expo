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
        $contactSection['support_cards'] = $this->pruneSupportCards($contactSection['support_cards'] ?? []);
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

    private function pruneSupportCards(array $cards): array
    {
        $removedIds = ['english_support', 'email_support'];
        $removedContacts = ['+966541164491'];

        return collect($cards)
            ->reject(function ($card) use ($removedIds) {
                return in_array($card['id'] ?? null, $removedIds, true);
            })
            ->map(function ($card) use ($removedContacts) {
                $columns = collect($card['columns'] ?? [])
                    ->map(function ($column) use ($removedContacts) {
                        $contacts = collect($column['contacts'] ?? [])
                            ->reject(function ($contact) use ($removedContacts) {
                                return in_array($contact['value'] ?? null, $removedContacts, true);
                            })
                            ->values()
                            ->all();

                        return array_merge($column, ['contacts' => $contacts]);
                    })
                    ->reject(function ($column) {
                        return empty($column['contacts']);
                    })
                    ->values()
                    ->all();

                $card['columns'] = $columns;

                return $card;
            })
            ->reject(function ($card) {
                return empty($card['columns']);
            })
            ->values()
            ->all();
    }
}
