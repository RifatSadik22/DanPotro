@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">Monthly Donations Report</h2>
                </div>
                <div class="card-body">
                    @if($monthlyDonations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Month</th>
                                        <th class="text-right">Total Donations</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($monthlyDonations as $donation)
                                        <tr>
                                            <td>{{ $donation['month'] }}</td>
                                            <td class="text-right">${{ number_format($donation['total'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center">No donations found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
