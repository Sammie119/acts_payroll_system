@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1>{{ __('Salaries Paid') }}</h1>
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
                            <div class="col-9">
                                <h5>{{ __('Salaries Paid for '. $staff_name->fullname) }}</h5>
                            </div>
                            {{-- <div class="col-2">
                                <input class="form-control" type="text" id="search" style="height: 32px">
                            </div> --}}
                            {{-- <div class="col-1">
                                <a href="{{ route('staff/create_staff') }}" class="btn btn-primary btn-sm">Add Staff</a>
                            </div> --}}
                        </div>  
                    </div>
                        <div class="card-body">
                            <table class="table table-striped table-advdruge table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Position</th>
                                        <th>Basic Salary</th>
                                        <th>Allowances</th>
                                        <th>Gross Sal.</th>
                                        <th>Deductions</th>
                                        <th>Net Sal.</th>
                                        <th>Month</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="employee_table">
                                    @forelse ($payments as $key => $payment)
                                        <tr>
                                            @php
                                                $pay_dep = App\Models\PayrollDependecy::where('id', $payment->depend_id)->first();
                                                $pay_loan = App\Models\LoanPayment::where('loan_pay_id', $payment->loan_pay_id)->first();

                                                $amount_incomes = floatval(array_sum($pay_dep->amount_incomes ?? [0]));
                                                $amount_deductions = floatval(array_sum($pay_dep->amount_deductions ?? [0])) + floatval($pay_dep->tax) + floatval($pay_dep->employee_ssf) + floatval($pay_loan->amount_paid ?? null);

                                            @endphp
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $payment->positon }}</td>
                                            <td>{{ number_format($payment->basic, 2) }}</td>
                                            <td>{{ number_format($amount_incomes, 2) }}</td>
                                            <td>{{ number_format($payment->gross_income, 2) }}</td>
                                            <td>{{ number_format($amount_deductions, 2) }}</td>
                                            <td>{{ number_format($payment->net_income, 2) }}</td>
                                            <td>{{ $payment->pay_month }}, {{ $payment->pay_year }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('view_payslip', [$payment->pay_id]) }}" class="btn btn-info btn-sm" title="View Details">View</a>
                                                    {{-- <button class="btn btn-success btn-sm edit" value="{{ $payment->id }}" data-bs-target="#getModal" data-bs-toggle="modal" title="Edit Details"><i class="fas fa-edit"></i></button>
                                                    <button class="btn btn-danger btn-sm delete" value="{{ $payment->id }}" data-bs-toggle="modal" data-bs-target="#comfirm-delete" role="button"><i class="fas fa-trash"></i></button> --}}
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


