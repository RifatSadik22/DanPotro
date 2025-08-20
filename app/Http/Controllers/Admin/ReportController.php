<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function generate(Request $request)
    {
        try {
            $request->validate([
                'month' => 'required|date_format:Y-m',
                'format' => 'required|in:csv,pdf'
            ]);

            $month = Carbon::parse($request->month);
            
            $donations = Donation::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->with(['user', 'campaign'])
                ->get();

            $totalAmount = $donations->sum('amount');
            $donorCount = $donations->unique('user_id')->count();

            if ($request->input('format') === 'csv') {
                return $this->generateCsvReport($donations, $month);
            }

            return $this->generatePdfReport($donations, $month, $totalAmount, $donorCount);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to generate report: ' . $e->getMessage());
        }
    }

    private function generateCsvReport($donations, $month): StreamedResponse
    {
        return response()->streamDownload(function() use ($donations) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Date', 'Donor', 'Campaign', 'Amount']);
            
            foreach ($donations as $donation) {
                fputcsv($file, [
                    $donation->created_at->format('Y-m-d'),
                    $donation->user->name,
                    $donation->campaign->title,
                    $donation->amount
                ]);
            }
            fclose($file);
        }, "donations-{$month->format('Y-m')}.csv");
    }

    private function generatePdfReport($donations, $month, $totalAmount, $donorCount)
    {
        $data = [
            'donations' => $donations,
            'month' => $month->format('F Y'),
            'totalAmount' => $totalAmount,
            'donorCount' => $donorCount
        ];

        return Pdf::loadView('admin.reports.pdf', $data)
            ->setPaper('a4')
            ->download("donations-{$month->format('Y-m')}.pdf");
    }
}
