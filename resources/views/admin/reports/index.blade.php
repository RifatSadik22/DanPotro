@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Monthly Donation Reports</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.reports.generate') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <input type="month" name="month" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <select name="format" class="form-control">
                        <option value="csv">CSV</option>
                        <option value="pdf">PDF</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Generate Report</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
