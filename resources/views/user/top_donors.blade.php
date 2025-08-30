@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Top Donors</h2>
        </div>
        <div class="space-y-4">
            @foreach($topDonors as $index => $donor)
                <div class="flex justify-between items-center p-3 hover:bg-gray-50 rounded {{ $index < 3 ? 'bg-blue-50' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="font-bold text-lg {{ $index < 3 ? 'text-blue-600' : '' }}">
                            #{{ $index + 1 }}
                        </span>
                        <span class="font-medium">{{ $donor->name }}</span>
                    </div>
                    <span class="text-green-600 font-semibold">
                        ${{ number_format($donor->total_amount, 2) }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
