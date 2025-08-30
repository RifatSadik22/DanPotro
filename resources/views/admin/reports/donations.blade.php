@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Monthly Donation Reports</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="text-left p-4 border-b">Month</th>
                        <th class="text-right p-4 border-b">Total Amount</th>
                        <th class="text-right p-4 border-b">Number of Donations</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($monthlyDonations as $report)
                        <tr class="hover:bg-gray-50">
                            <td class="p-4 border-b">{{ date('F Y', strtotime($report->month)) }}</td>
                            <td class="text-right p-4 border-b">${{ number_format($report->total_amount, 2) }}</td>
                            <td class="text-right p-4 border-b">{{ $report->donation_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
