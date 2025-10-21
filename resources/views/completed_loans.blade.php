@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-10">
                            <h5>{{ __('Manually Completed Loans') }}</h5>
                        </div>
                        <div class="col-2">
                            <a class="btn btn-secondary btn-sm float-end" href="{{ url()->previous() }}">Back</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-striped table-advdruge table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Staff Name</th>
                            <th>Loan Desc.</th>
                            <th>Amount</th>
                            <th>Amnt/Month</th>
                            <th>Amnt Paid</th>
                            <th>Balance</th>
                            <th>Months Paid</th>
                            <th>Months Left</th>
                            <th>Reason</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="employee_table">
                        @forelse ($completed as $key => $loan)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $loan->staff->fullname }}</td>
                                <td>{{ $loan->loan->description }}</td>
                                <td>{{ number_format($loan->amount_paid + $loan->amount_left, 2) }}</td>
                                <td>{{ number_format($loan->monthly_payment, 2) }}</td>
                                <td>{{ number_format($loan->amount_paid, 2) }}</td>
                                <td>{{ number_format($loan->amount_left, 2) }}</td>
                                <td>{{ $loan->months_paid }}</td>
                                <td>{{ $loan->months_left }}</td>
                                <td>{{ $loan->reason }}</td>
                                <td>
                                    <div class="btn-group">
                                        @if ($loan->status !== 2)
                                            <a href="{{ route('loan.complete',[$loan->loan_id]) }}" class="btn btn-secondary btn-sm" title="View Details">Stop</a>
                                        @endif
                                        <a href="loans/delete_loan/{{ $loan->loan_id }}" onclick="return confirm('The Selected record will be deleted permanently!!!')" class="btn btn-danger btn-sm" >Del</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="25">No Data Found</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
