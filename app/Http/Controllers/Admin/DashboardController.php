<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SponsorRegistration;
use App\Models\VisitorRegistration;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSponsors  = SponsorRegistration::count();
        $totalVisitors  = VisitorRegistration::count();
        $todaySponsors  = SponsorRegistration::whereDate('created_at', today())->count();
        $todayVisitors  = VisitorRegistration::whereDate('created_at', today())->count();

        return view('admin.dashboard', compact(
            'totalSponsors',
            'totalVisitors',
            'todaySponsors',
            'todayVisitors'
        ));
    }
}
