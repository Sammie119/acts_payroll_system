<!DOCTYPE>
<html>
<head>
	<style type="text/css">
        html { 
            margin: 20px
        }

        #logo{
            text-align: center;
            border-bottom: 2px solid;
            width: 100%;
            margin-right: 14px;
        }

        /* tr {
            padding-top: 0px;
        } */

        table {
            width: 100%;
            border-collapse: collapse;
        }

        tr {
            border-bottom: 1pt solid black;
        }

        td {
            padding-top: 5px;
            padding-bottom: 5px;
        }

        th {
            padding-top: 5px;
            padding-bottom: 5px;
        }

        #logo-text {
            font-size: 1.5rem; 
            font-weight: bold;
            margin-bottom: 5px;
            margin-top: 0px;
            text-transform: uppercase;
        }

        button {
            float: right;
            padding-top: 10px;
            padding-bottom: 10px;
            padding-right: 20px;
            padding-left: 20px;
            font-weight: bolder;
            border: solid 1px;
            border-radius: 20px;
            position: relative;
            margin-right: 5%;
        }

        .page-break {
            page-break-after: always;
        }

        .center {
            display: block;
            margin-left: auto;
            margin-right: auto;
            margin-top: 0%; 
        }

        .watermark {
            position: absolute;
            opacity: 0.15;
            width: 100%;
            top: 30%;    
            text-align: center;
            z-index: 0;
        }

        #header {
            text-align: center;
        }
    </style>

</head>
<body>
    
    @foreach ($payment as $pay)
        @php
            $staff = \App\Models\VWStaff::where('staff_id', $pay->staff_id)->first();
        @endphp

        <div class="page-break" style="width: 100%;" >
            <header id="header">
                <img class="center" src="{{ public_path('build/assets/images/acts_logo.jpg') }}" width="300px" height="150px" alt="ACTS_logo">
                <div id="logo" style="margin-top: -2%">
                    <h5 id="logo-text">Payslip</h5>
                </div>
            </header>

            <div class = "data">
                <div class="watermark"><img src="{{ public_path('build/assets/images/acts_logo_alone.jpg') }}" width="300px" height="400px"></div>
                <table class="table border-secondary table-sm mt-2">
                    <tr>
                        <td style="width: 20%">Name: </td>
                        <td style="width: 40%">{{ $staff->fullname }}</td>
                        <td style="width: 20%;">Month: </td>
                        <td style="width: 20%;" nowrap>{{ $pay->pay_month }}, {{ $pay->pay_year }}</td>
                    </tr>
                    <tr>
                        <td style="width: 20%">Position: </td>
                        <td style="width: 40%">{{ $staff->position }}</td>
                        <td style="width: 20%">Staff ID: </td>
                        <td style="width: 20%">{{ $staff->staff_number }}</td>
                    </tr>
                    <tr>
                        <td style="width: 20%">Bank: </td>
                        <td style="width: 40%">{{ $staff->banker }}, {{ $staff->bank_branch }}</td>
                        <td style="width: 20%;">SSF Number: </td>
                        <td style="width: 20%;">{{ $staff->ssnit_number }}</td>
                    </tr>
                    <tr>
                        <td style="width: 20%" nowrap>Account No.: </td>
                        <td style="width: 40%">{{ $staff->bank_account }}</td>
                        <td style="width: 20%;" nowrap>Annual Salary:</td>
                        <td style="width: 20%;">{{ number_format($pay->basic * 12, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="5"><br></td>
                    </tr>
                    <tr>
                        <th colspan="5" style="text-align: left; background: #eee">Earnings</th>
                    </tr>
                    <tr>
                        <td style="width: 20%">Basic Salary</td>
                        <td style="width: 40%"></td>
                        <td style="width: 20%; text-align:right; padding-right:20px">{{ number_format($pay->basic, 2) }}</td>
                        <td style="width: 20%;"></td>
                    </tr>
                    @php
                        $allowances = \App\Models\PayrollDependecy::where('id', $pay->depend_id)->first();
                        $total_paid_loan = 0;
                    @endphp

                    @if(!empty($allowances->incomes))            
                        @foreach ($allowances->incomes as $i => $incomes)
                        <tr>
                            <td style="width: 20%" nowrap>{{ $incomes }}</td>
                            <td style="width: 40%"></td>
                            <td style="width: 20%; text-align:right; padding-right:20px"">{{ number_format($allowances->amount_incomes[$i], 2) }}</td>
                            <td style="width: 20%;"></td>
                        </tr>
                        @endforeach
                    @endif
                    
                    <tr>
                        <th style="width: 20%">Gross Pay</th>
                        <td style="width: 40%"></td>
                        <td style="width: 20%;"></td>
                        <th style="width: 20%; text-align:right; padding-right:20px"">{{ number_format($pay->gross_income, 2) }}</th>
                    </tr>
                    <tr>
                        <td colspan="5"><br></td>
                    </tr>

                    @if ($staff->age <= 60)
                        <tr>
                            <td style="width: 20%">Employer SSF</td>
                            <td style="width: 40%"></td>
                            <td style="width: 20%; text-align:right; padding-right:20px"">{{ number_format($allowances->employer_ssf, 2) }}</td>
                            <td style="width: 20%;"></td>
                        </tr>
                        <tr>
                            <td colspan="5"><br></td>
                        </tr>    
                    @endif
                    
                    <tr>
                        <th colspan="5" style="text-align: left; background: #eee">Deductions</th>
                    </tr>
                    <tr>
                        <td style="width: 20%">Income Tax</td>
                        <td style="width: 40%"></td>
                        <td style="width: 20%; text-align:right; padding-right:20px"">{{ number_format($allowances->tax, 2) }}</td>
                        <td style="width: 20%;"></td>
                    </tr>

                    @if ($staff->age <= 60)
                        <tr>
                            <td style="width: 20%">Employee SSF</td>
                            <td style="width: 40%"></td>
                            <td style="width: 20%; text-align:right; padding-right:20px"">{{ number_format($allowances->employee_ssf, 2) }}</td>
                            <td style="width: 20%;"></td>
                        </tr>
                    @endif
                    
                    @if(!empty($allowances->deductions))
                        @foreach ($allowances->deductions as $i => $deductions)
                        <tr>
                            <td style="width: 20%" nowrap>{{ $deductions }}</td>
                            <td style="width: 40%"></td>
                            <td style="width: 20%; text-align:right; padding-right:20px"">{{ number_format($allowances->amount_deductions[$i], 2) }}</td>
                            <td style="width: 20%;"></td>
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
                                <td style="width: 20%" nowrap colspan="2">{{ $paid_loan->loan->description }} &ensp; (<b>Principal:</b> {{ number_format($paid_loan->amount, 2) }} <b>Paid:</b> {{ number_format($paid_loan->total_amount_paid, 2) }} <b>Balance:</b> {{ number_format($paid_loan->amount - $paid_loan->total_amount_paid, 2) }})</td>
                                {{-- <td style="width: 40%"></td> --}}
                                <td style="width: 20%; text-align:right; padding-right:20px"">{{ number_format($paid_loan->amount_paid, 2) }}</td>
                                <td style="width: 20%;"></td>
                            </tr>
                        @endforeach
                    @endif
                    
                    <tr>
                        <th style="width: 20%">Total Deduction</th>
                        <td style="width: 40%"></td>
                        <td style="width: 20%;"></td>
                        <th style="width: 20%; text-align:right; padding-right:20px"">{{ number_format(($staff->age <= 60) ? (array_sum($allowances->amount_deductions ?? [0]) + $allowances->tax + $allowances->employee_ssf + $total_paid_loan) : (array_sum($allowances->amount_deductions ?? [0]) + $allowances->tax + $total_paid_loan), 2) }}</th>
                    </tr>
                    <tr>
                        <td colspan="5"><br></td>
                    </tr>
                    <tr>
                        <th style="width: 20%">Net Pay</th>
                        <td style="width: 40%"></td>
                        <td style="width: 20%;"></td>
                        <th style="width: 20%; text-align:right; padding-right:20px"">{{ number_format(($staff->age <= 60) ? $pay->net_income : $pay->net_income + $allowances->employee_ssf, 2) }}</th>
                    </tr>
                    <tr>
                        <td colspan="5"><br></td>
                    </tr>
                    <tr>
                        <td style="width: 20%">Total SSF</td>
                        <th style="width: 40%">{{ number_format(($staff->age <= 60) ? $allowances->employer_ssf + $allowances->employee_ssf : 0, 2) }}</th>
                        <td style="width: 20%;">Tax Relief</td>
                        <th style="width: 20%; text-align:right; padding-right:20px"">{{ number_format($allowances->tax_relief, 2) }}</th>
                    </tr>
                </table>

            </div>        
        </div>
        {{-- <div class=""></div> --}}
        
    @endforeach
</body>

</html>

