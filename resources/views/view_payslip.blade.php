@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-10">
                            <h5>Salary details for {{ $pay->pay_month }}, {{ $pay->pay_year }}</h5>
                        </div>
                        <div class="col-2">
                            <a class="btn btn-secondary btn-sm float-end" href="{{ url()->previous() }}">Back</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table">
                        <tbody>
                          <tr>
                            <th scope="row">Staff Name</th>
                            <td>{{ $staff->fullname }}</td>
                            <td></td>
                          </tr>
                          <tr>
                            <th scope="row">Annual Salary</th>
                            <td>{{ number_format($pay->basic * 12, 2) }}</td>
                            <td></td>
                          </tr>
                          <tr>
                            <th scope="row">Basic Salary</th>
                            <td>{{ number_format($pay->basic, 2) }}</td>
                            <td></td>
                          </tr>

                          @php
                             $allowances = \App\Models\PayrollDependecy::where('id', $pay->depend_id)->first();
                             $total_paid_loan = 0;
//                             dd($allowances->tier_3);
                          @endphp

                          @if(!empty($allowances->incomes))
                            <tr>
                              <th scope="row" colspan="3">Allowances</th>
                            </tr>

                            @foreach ($allowances->incomes as $i => $incomes)
                              <tr>
                                  <th scope="row" style="padding-left: 50px;">{{ $incomes }}</th>
                                  <td>{{ number_format($allowances->amount_incomes[$i], 2) }}</td>
                                  <td></td>
                              </tr>
                            @endforeach
                          @endif


                          <tr>
                            <th scope="row">Total Earning</th>
                            <td></td>
                            <td>{{ number_format($pay->gross_income, 2) }}</td>
                          </tr>

                          <tr>
                            <th scope="row" style="padding-left: 50px;">SSF Employer</th>
                            <td>{{ number_format($allowances->employer_ssf, 2) }}</td>
                            <td></td>
                          </tr>

                          <tr>
                            <th scope="row" colspan="3">Deductions</th>
                          </tr>
                          <tr>
                            <th scope="row" style="padding-left: 50px;">Income Tax</th>
                            <td>{{ number_format($allowances->tax, 2) }}</td>
                            <td></td>
                          </tr>
                          <tr>
                            <th scope="row" style="padding-left: 50px;">SSF Employee</th>
                            <td>{{ number_format($allowances->employee_ssf, 2) }}</td>
                            <td></td>
                          </tr>

                          @if(!empty($allowances->deductions))
                            @foreach ($allowances->deductions as $i => $deductions)
                              <tr>
                                  <th scope="row" style="padding-left: 50px;">{{ $deductions }}</th>
                                  <td>{{ number_format($allowances->amount_deductions[$i], 2) }}</td>
                                  <td></td>
                              </tr>
                            @endforeach
                          @endif

                          @if(!empty($allowances->loan_ids))
                            @foreach ($allowances->loan_ids as $i => $loan_id)
                              @php
                                $paid_loan = \App\Models\LoanPayment::where('loan_pay_id', $loan_id)->first();
                                $total_paid_loan += $paid_loan->amount_paid;
                              @endphp
                              <tr>
                                  <th scope="row" style="padding-left: 50px;">{{ $paid_loan->loan->description }}</th>
                                  <td>{{ number_format($paid_loan->amount_paid, 2) }} (Bal: {{ number_format($paid_loan->amount - $paid_loan->total_amount_paid, 2) }})</td>
                                  <td></td>
                              </tr>

                            @endforeach
                          @endif

                          @if($allowances->tier_3 > 0)
                              <tr>
                                  <th scope="row" style="padding-left: 50px;">Tier 3</th>
                                  <td>{{ number_format($allowances->tier_3, 2) }}</td>
                                  <td></td>
                              </tr>
                          @endif

                          <tr>
                            <th scope="row" style="width: 40%">Total Deductions</th>
                            <td></td>
                            <td>({{ number_format((array_sum($allowances->amount_deductions ?? [0]) + $allowances->tax + $allowances->employee_ssf + $total_paid_loan + $allowances->tier_3), 2) }})</td>
                          </tr>
                          <tr>
                            <th scope="row">Net Income</th>
                            <td></td>
                            <td>{{ number_format($pay->net_income - $allowances->tier_3, 2) }}</td>
                          </tr>

                          <tr>
                            <th scope="row">Tax Relief</th>
                            <td></td>
                            <td>{{ number_format($allowances->tax_relief, 2) }}</td>
                          </tr>

{{--                          @if ($allowances->tier_3 > 0)--}}
{{--                            <tr>--}}
{{--                              <th scope="row">Tier 3</th>--}}
{{--                              <td></td>--}}
{{--                              <td>{{ number_format($allowances->tier_3, 2) }}</td>--}}
{{--                            </tr>--}}
{{--                          @endif--}}

                        </tbody>
                    </table>
                    <div style="text-align: center">
                        <a href="{{ route('get_payslip', [$pay->pay_id]) }}" class="btn btn-dark">Get Payslip</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

