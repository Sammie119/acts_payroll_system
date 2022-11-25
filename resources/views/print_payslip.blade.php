<!DOCTYPE>
 <html>

    <title>ACTS_Payslip_{{ $staff->staff_number }}</title>
    <link rel="shortcut icon" href="{{ asset('public/build/assets/images/smmie_logo.ico') }}" type="image/ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

	<style type="text/css">
        #logo{
            text-align: center;
            border-bottom: 2px solid;
            /* margin-bottom: 10px; */
            margin-right: 14px;
        }

        tr {
            padding-top: 0px;
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

        @media print {
            .noprint, #back{
                visibility: hidden;
            }

            #myheader_opd {
                position: fixed;
                top: 0;
                right: 0; 
                }

            /* @page{
                size: landscape;
            } */

            tfoot{
                page-break-before: always;
            }
        }

        @media screen {
            #myheader_opd{
            display: none;
            }

            /* br {
                display: none;
            } */
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
    </style>

	<script type="text/javascript">
		function print_1(){
			window.print();
			window.location = "{{ url()->previous() }}";
		}
	</script>

</head>

    <body style="width: 100%;" >

        <div id="back"><a href="{{ url()->previous() }}">Back</a></div>
        <header id="header">
            <img class="center" src="{{ asset('public/build/assets/images/acts_logo.jpg') }}" width="300px" height="150px" alt="ACTS_logo">
            <div id="logo" style="margin-top: -2%">
                <h5 id="logo-text">Payslip</h5>
            </div>
        </header>

        <div class = "data">
            <div class="watermark"><img src="{{ asset('public/build/assets/images/acts_logo.jpg') }}" width="800px" height="400px"></div>
            <table class="table border-secondary table-sm mt-2">
                <tr>
                    <td style="width: 20%">Name: </td>
                    <td style="width: 40%">{{ $staff->fullname }}</td>
                    <td style="width: 20%;">Month: </td>
                    <td style="width: 20%;">{{ $pay->pay_month }}, {{ $pay->pay_year }}</td>
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
                    <td style="width: 20%">Account No.: </td>
                    <td style="width: 40%">{{ $staff->bank_account }}</td>
                    <td style="width: 20%;">Annual Salary:</td>
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
                    <td style="width: 20%;">{{ number_format($pay->basic, 2) }}</td>
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
                        <td style="width: 20%;">{{ number_format($allowances->amount_incomes[$i], 2) }}</td>
                        <td style="width: 20%;"></td>
                    </tr>
                    @endforeach
                @endif
                
                <tr>
                    <th style="width: 20%">Gross Pay</th>
                    <td style="width: 40%"></td>
                    <td style="width: 20%;"></td>
                    <th style="width: 20%;">{{ number_format($pay->gross_income, 2) }}</th>
                </tr>
                <tr>
                    <td colspan="5"><br></td>
                </tr>
                <tr>
                    <td style="width: 20%">Employer SSF</td>
                    <td style="width: 40%"></td>
                    <td style="width: 20%;">{{ number_format($allowances->employer_ssf, 2) }}</td>
                    <td style="width: 20%;"></td>
                </tr>
                <tr>
                    <td colspan="5"><br></td>
                </tr>
                <tr>
                    <th colspan="5" style="text-align: left; background: #eee">Deductions</th>
                </tr>
                <tr>
                    <td style="width: 20%">Income Tax</td>
                    <td style="width: 40%"></td>
                    <td style="width: 20%;">{{ number_format($allowances->tax, 2) }}</td>
                    <td style="width: 20%;"></td>
                </tr>
                <tr>
                    <td style="width: 20%">Employee SSF</td>
                    <td style="width: 40%"></td>
                    <td style="width: 20%;">{{ number_format($allowances->employee_ssf, 2) }}</td>
                    <td style="width: 20%;"></td>
                </tr>
                @if(!empty($allowances->deductions))
                    @foreach ($allowances->deductions as $i => $deductions)
                    <tr>
                        <td style="width: 20%" nowrap>{{ $deductions }}</td>
                        <td style="width: 40%"></td>
                        <td style="width: 20%;">{{ number_format($allowances->amount_deductions[$i], 2) }}</td>
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
                            <td style="width: 20%" nowrap colspan="2">{{ $paid_loan->loan->description }} &ensp; (Balance: {{ number_format($paid_loan->amount - $paid_loan->total_amount_paid, 2) }})</td>
                            {{-- <td style="width: 40%"></td> --}}
                            <td style="width: 20%;">{{ number_format($paid_loan->amount_paid, 2) }}</td>
                            <td style="width: 20%;"></td>
                        </tr>
                    @endforeach
                @endif
                
                <tr>
                    <th style="width: 20%">Total Deduction</th>
                    <td style="width: 40%"></td>
                    <td style="width: 20%;"></td>
                    <th style="width: 20%;">{{ number_format((array_sum($allowances->amount_deductions ?? [0]) + $allowances->tax + $allowances->employee_ssf + $total_paid_loan), 2) }}</th>
                </tr>
                <tr>
                    <td colspan="5"><br></td>
                </tr>
                <tr>
                    <th style="width: 20%">Net Pay</th>
                    <td style="width: 40%"></td>
                    <td style="width: 20%;"></td>
                    <th style="width: 20%;">{{ number_format($pay->net_income, 2) }}</th>
                </tr>
                <tr>
                    <td colspan="5"><br></td>
                </tr>
                <tr>
                    <th style="width: 20%">Total SSF</th>
                    <td style="width: 40%">{{ number_format($allowances->employer_ssf + $allowances->employee_ssf, 2) }}</td>
                    <td style="width: 20%;">Tax Relief</td>
                    <th style="width: 20%;">{{ number_format($allowances->tax_relief, 2) }}</th>
                </tr>
            </table>

        </div>

        
        <button class="noprint btn btn-outline-dark" onclick="print_1()"> &#128438; Print</button>
		
    </body>
</html>

