<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function donationReports()
    {
        $monthlyReports = Donation::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('SUM(amount) as total_amount'),
            DB::raw('COUNT(*) as donation_count')
        )
        ->groupBy('month')
        ->orderByDesc('month')
        ->get();

        return view('admin.donations_report', compact('monthlyReports'));
    }

    public function monthlyDonations()
    {
        return Donation::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('SUM(amount) as total_amount')
        )
        ->groupBy('month')
        ->orderBy('month', 'desc')
        ->get()
        ->pluck('total_amount', 'month')
        ->toArray();
    }

    public function weeklyDonations()
    {
        return Donation::select(
            DB::raw("CONCAT(YEAR(created_at), '-', LPAD(WEEK(created_at, 1), 2, '0')) as week_number"),
            DB::raw('SUM(amount) as total_amount')
        )
        ->groupBy('week_number')
        ->orderBy('week_number', 'desc')
        ->get()
        ->pluck('total_amount', 'week_number')
        ->toArray();
    }
}
