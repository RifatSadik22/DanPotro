<!DOCTYPE html>
<html>
<head>
    <title>Monthly Donation Report - {{ $month }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid #ddd; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Donation Report - {{ $month }}</h1>
        <p>Total Amount: ${{ number_format($totalAmount, 2) }}</p>
        <p>Total Donors: {{ $donorCount }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Donor</th>
                <th>Campaign</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($donations as $donation)
                <tr>
                    <td>{{ optional($donation->created_at)->format('Y-m-d') }}</td>
                    <td>{{ $donation->user->name }}</td>
                    <td>{{ $donation->campaign->title }}</td>
                    <td>${{ number_format($donation->amount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
