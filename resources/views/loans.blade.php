@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1>{{ __('Loans List') }}</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row d-flex justify-content-center">
                <div class="col-md-12">
                    <div class="card card-primary">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-7">
                                <h5>{{ __('Loans List') }}</h5>
                            </div>
                            <div class="col-2">
                                <a href="{{ route('manuallyCompletedLoans') }}" class="btn btn-danger btn-sm float-end">Completed Loans</a>
                            </div>
                            <div class="col-2">
                                <input class="form-control" type="text" id="search" style="height: 32px">
                            </div>
                            <div class="col-1">
                                <a href="{{ route('loans/create_loan') }}" class="btn btn-primary btn-sm">New Loan</a>
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
                                        <th>Months Left </th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="employee_table">
                                    @forelse ($loans as $key => $loan)
                                        @php
                                            $amount = $loan->amount;
                                            $amnt_paid = $loan->loan_pay->last()->total_amount_paid;
                                            $balance = $amount - $amnt_paid;
                                        @endphp

                                        @if (($loan->staff->fullname ?? null) !== null)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $loan->staff->fullname }}</td>
                                                <td>{{ $loan->description }}</td>
                                                <td>{{ number_format($amount, 2) }}</td>
                                                <td>{{ number_format($loan->amount_per_month, 2) }}</td>
                                                <td>{{ number_format($amnt_paid, 2) }}</td>
                                                <td>{{ number_format($balance, 2) }}</td>
                                                <td>{{ $stop = $loan->number_of_months - $loan->loan_pay->last()->months_paid }}</td>
                                                <td>{{ getLoanStatus($loan->status) }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('loan.payment',[$loan->loan_id]) }}" class="btn btn-info btn-sm" title="View Details">Veiw</a>
                                                        <a href="{{ route('loan.edit',[$loan->loan_id]) }}" class="btn btn-success btn-sm" title="Edit Details">Edit</a>
                                                        @if ($loan->status !== 2)
                                                            <a href="{{ route('loan.complete',[$loan->loan_id]) }}" class="btn btn-secondary btn-sm" title="View Details">Stop</a>
                                                        @endif
                                                        <a href="loans/delete_loan/{{ $loan->loan_id }}" onclick="return confirm('The Selected record will be deleted permanently!!!')" class="btn btn-danger btn-sm" >Del</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
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
    </section>
</div>
@endsection

<script>
    window.onload = function(){
        $('#search').focus();

        // Table filter
        $('#search').keyup(function(){
            search_table($(this).val());
        });
        function search_table(value){
            $('#employee_table tr').each(function(){
                var found = 'false';
                $(this).each(function(){
                    if($(this).text().toLowerCase().indexOf(value.toLowerCase()) >= 0){
                        found = 'true';
                    }
                });
                if(found == 'true'){
                    $(this).show();
                }
                else{
                    $(this).hide();
                }
            });
        }

    };
</script>


