<!DOCTYPE>
 <html>

    <title>ACTS | Report</title>
    <link rel="shortcut icon" href="{{ asset('public/build/assets/images/smmie_logo.ico') }}" type="image/ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

	<style type="text/css">
        #logo{
            text-align: center;
            border-bottom: 2px solid;
            width: 100%;
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

            /* tfoot{
                page-break-before: always;
            } */
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
            <div id="logo">
                <h6 id="logo-text">{{ $header }}</h6>
            </div>
        </header>

        @switch($report)
            @case('Bankers')
                <div class = "data">
                    <table class="table border-secondary table-sm mt-2">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Staff Name</th>
                                <th>Sort Code</th>
                                <th>Bank</th>
                                <th>Bank Branch</th>
                                <th>Account Number</th>
                                <th style="text-align: right;">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total_salary = 0;
                            @endphp
                            @foreach ($data as $key => $staff)
                                @php
                                    $total_salary += $staff->net_income;
                                @endphp
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $staff->fullname }}</td>
                                    <td>{{ $staff->bank_sort_code }}</td>
                                    <td>{{ $staff->banker }}</td>
                                    <td>{{ $staff->bank_branch }}</td>
                                    <td>{{ $staff->bank_account }}</td>
                                    <td style="text-align: right;">{{ number_format($staff->net_income, 2) }}</td>
                                </tr> 
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" style="text-align: center">GRAND TOTAL</th>
                                <th colspan="5" style="text-align: right;">{{ number_format($total_salary, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @break

            @case('tier_1')
                <div class = "data">
                    <table class="table border-secondary table-sm mt-2">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Staff Name</th>
                                <th>Social Security No</th>
                                <th>NIA Number</th>
                                <th style="text-align: right;">Basic Salary</th>
                                <th style="text-align: right;">1st Tier</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total_salary = 0;
                                $total_ssf = 0;
                            @endphp
                            @foreach ($data as $key => $staff)
                                @php
                                    $total_ssf += $staff->tier_1;
                                    $total_salary += $staff->basic;
                                @endphp
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $staff->fullname }}</td>
                                    <td>{{ $staff->ssnit_number }}</td>
                                    <td>{{ $staff->ghana_card }}</td>
                                    <td style="text-align: right;">{{ $staff->basic }}</td>
                                    <td style="text-align: right;">{{ number_format($staff->tier_1, 2) }}</td>
                                </tr> 
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" style="text-align: center">GRAND TOTAL</th>
                                <th colspan="3" style="text-align: right;">{{ number_format($total_salary, 2) }}</th>
                                <th style="text-align: right;">{{ number_format($total_ssf, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @break

            @case('tier_2')
                <div class = "data">
                    <table class="table border-secondary table-sm mt-2">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Staff Name</th>
                                <th>Social Security No</th>
                                <th>NIA Number</th>
                                <th style="text-align: right;">Basic Salary</th>
                                <th style="text-align: right;">2nd Tier</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total_salary = 0;
                                $total_ssf = 0;
                            @endphp
                            @foreach ($data as $key => $staff)
                                @php
                                    $total_ssf += $staff->tier_2;
                                    $total_salary += $staff->basic;
                                @endphp
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $staff->fullname }}</td>
                                    <td>{{ $staff->ssnit_number }}</td>
                                    <td>{{ $staff->ghana_card }}</td>
                                    <td style="text-align: right;">{{ $staff->basic }}</td>
                                    <td style="text-align: right;">{{ number_format($staff->tier_2, 2) }}</td>
                                </tr> 
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" style="text-align: center">GRAND TOTAL</th>
                                <th colspan="3" style="text-align: right;">{{ number_format($total_salary, 2) }}</th>
                                <th style="text-align: right;">{{ number_format($total_ssf, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @break

            @case('paye_tax')
                <div class = "data">
                    <table class="table border-secondary table-sm mt-2">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>TIN Number</th>
                                <th>Name of Employee</th>
                                <th>Position</th>
                                <th>Non<br>Resident<br>(Y / N)</th>
                                <th style="text-align: right;">Basic Salary</th>
                                <th>Secondary<br>Employment<br>(Y / N)</th>
                                <th>Paid<br>SSNIT<br>(Y / N)</th>
                                <th>Total<br>Allowances</th>
                                <th>Tax Relief</th>
                                <th>Tier 3</th>
                                <th>Total Taxable<br>Income</th>
                                <th style="text-align: right;">Payable<br>GRA</th>
                                <th>Severance<br>pay paid</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total_salary = 0;
                                $total_tax = 0;
                                $total_tax_relief_s = 0;
                                $total_tier_3 = 0;
                                $total_allowances_s = 0;
                                $total_taxable_income_s = 0;

                                $data_array = [];
                            @endphp
                            @foreach ($data as $key => $staff)
                                @php
                                    $month = $date['month'];
                                    $tax = \App\Models\VWTax::select('tax', 'tax_relief', 'tier_3', 'incomes', 'amount_incomes')->where([
                                            ['staff_id', $staff->staff_id],
                                            ['pay_year', $date['year']],
                                        ])->whereRaw("pay_month collate utf8mb4_unicode_ci = '$month'")->orderByDesc('pay_id')->first();
                                        // dd(json_decode($tax->amount_incomes));
                            
                                    $position = 'Junior';
                                    $resident = 'N';
                                    $secondary = 'N';
                                    $paid_ssnit = ($staff->age >= 60) ? 'N' : 'Y';
                                    $total_allowance = array_sum(getTaxableAllowancesAmount(json_decode($tax->incomes), json_decode($tax->amount_incomes))); //array_sum(json_decode($tax->amount_incomes ?? "[0]"));
                                    $tax_relief = $tax->tax_relief;
                                    $tier_3 = $tax->tier_3;
                                    $total_taxable_income = ($total_allowance + $staff->basic) - ($tax_relief + $tier_3);
                                    $severance = '0';
                                    $remarks = NULL;

                                    $total_tax += $tax->tax;
                                    $total_salary += $staff->basic;
                                    $total_tax_relief_s += $tax_relief;
                                    $total_tier_3 += $tier_3;
                                    $total_allowances_s += $total_allowance;
                                    $total_taxable_income_s += $total_taxable_income;

                                    $data_array[] = [
                                        'tin_number' => $staff->tin_number,
                                        'fullname' => $staff->fullname,
                                        'position' => $position,
                                        'n_resident' => $resident,
                                        'basic_salary' => $staff->basic,
                                        'secondary' => $secondary,
                                        'paid_ssnit' => $paid_ssnit,
                                        'total_allowance' => $total_allowance,
                                        'tax_relief' => $tax_relief,
                                        'tier_3' => $tier_3,
                                        'total_taxable_income' => $total_taxable_income,
                                        'payable' => $tax->tax,
                                        'severance' => $severance,
                                        'remarks' => $remarks,
                                    ];
                                @endphp
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $staff->tin_number }}</td>
                                    <td>{{ $staff->fullname }}</td>
                                    <td>{{ $position }}</td>
                                    <td style="text-align: center;">{{ $resident }}</td>
                                    <td style="text-align: right;">{{ number_format($staff->basic, 2) }}</td>
                                    <td style="text-align: center;">{{ $secondary }}</td>
                                    <td>{{ $paid_ssnit }}</td>
                                    <td style="text-align: right;">{{ number_format($total_allowance, 2) }}</td>
                                    <td style="text-align: right;">{{ number_format($tax_relief, 2) }}</td>
                                    <td style="text-align: right;">{{ number_format($tier_3, 2) }}</td>
                                    <td style="text-align: right;">{{ number_format($total_taxable_income, 2) }}</td>
                                    <td style="text-align: right;">{{ number_format($tax->tax, 2) }}</td>
                                    <td style="text-align: center;">{{ $severance }}</td>
                                    <td style="text-align: center;">{{ $remarks }}</td>
                                </tr> 
                            @endforeach
                                <tr>
                                    <th colspan="5" style="text-align: center">GRAND TOTAL</th>
                                    <th style="text-align: right;">{{ number_format($total_salary, 2) }}</th>
                                    <th colspan="3" style="text-align: right;">{{ number_format($total_allowances_s, 2) }}</th>
                                    <th style="text-align: right;">{{ number_format($total_tax_relief_s, 2) }}</th>
                                    <th style="text-align: right;">{{ number_format($total_tier_3, 2) }}</th>
                                    <th style="text-align: right;">{{ number_format($total_taxable_income_s, 2) }}</th>
                                    <th style="text-align: right;">{{ number_format($total_tax, 2) }}</th>
                                    <th colspan="2"></th>
                                </tr>
                        </tbody>
                            @php
                                Illuminate\Support\Facades\Cache::put('paye_tax', collect($data_array), now()->addHours(2));
                            @endphp
                    </table>
                </div>
                @break

            @case('welfare')
                <div class = "data">
                    <table class="table border-secondary table-sm mt-2">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Staff ID</th>
                                <th>Staff Name</th>
                                <th>Position</th>
                                <th style="text-align: right;">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total_welfare = 0;
                            @endphp
                            @foreach ($data as $key => $staff)
                                @php
                                    $total_welfare += $staff->welfare;
                                @endphp
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $staff->staff_number }}</td>
                                    <td>{{ $staff->fullname }}</td>
                                    <td>{{ $staff->position }}</td>
                                    <td style="text-align: right;">{{ number_format($staff->welfare, 2) }}</td>
                                </tr> 
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" style="text-align: center">GRAND TOTAL</th>
                                <th colspan="4" style="text-align: right;">{{ number_format($total_welfare, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @break

            @case('credit_union')
                <div class = "data">
                    <table class="table border-secondary table-sm mt-2">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Staff ID</th>
                                <th>Staff Name</th>
                                <th>Description</th>
                                <th style="text-align: right;">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total_amount = 0;
                                $key = 0;
                                $data_array = [];
                            @endphp
                            @foreach ($data as $staff)                                
                                @if (in_array('Credit Union Saving', json_decode($staff->deductions)))
                                    @php
                                        $index = array_search('Credit Union Saving', json_decode($staff->deductions));
                                        $amount = json_decode($staff->amount_deductions);
                                        $total_amount += $amount[$index];
                                        $key += 1;

                                        $data_array[] = [
                                            'staff_number' => $staff->staff_number,
                                            'fullname' => $staff->fullname,
                                            'description' => 'Credit Union Saving',
                                            'amount' => $amount[$index]
                                        ];
                                    @endphp
                                    <tr>
                                        <td>{{ $key }}</td>
                                        <td>{{ $staff->staff_number }}</td>
                                        <td>{{ $staff->fullname }}</td>
                                        <td>Credit Union Saving</td>
                                        <td style="text-align: right;">{{ number_format($amount[$index], 2) }}</td>
                                    </tr>
                                @endif 
                            @endforeach
                            @php
                                Illuminate\Support\Facades\Cache::put('credit_union', collect($data_array), now()->addHours(2));
                            @endphp
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" style="text-align: center">GRAND TOTAL</th>
                                <th colspan="3" style="text-align: right;">{{ number_format($total_amount, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @break

            @case('rent')
                <div class = "data">
                    <table class="table border-secondary table-sm mt-2">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Staff ID</th>
                                <th>Staff Name</th>
                                <th>Description</th>
                                <th style="text-align: right;">Amount</th>
                                <th style="text-align: right;">Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total_paid = 0;
                                $total_balance = 0;
                            @endphp
                            @foreach ($data as $key => $staff)
                                @php
                                    $total_paid += $staff->amount_paid;
                                    $balance = $staff->amount - $staff->total_amount_paid;
                                    $total_balance += $balance;
                                @endphp
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $staff->staff_number }}</td>
                                    <td>{{ $staff->fullname }}</td>
                                    <td>{{ $staff->description }}</td>
                                    <td style="text-align: right;">{{ number_format($staff->amount_paid, 2) }}</td>
                                    <td style="text-align: right;">{{ number_format($balance, 2) }}</td>
                                </tr> 
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" style="text-align: center">GRAND TOTAL</th>
                                <th colspan="3" style="text-align: right;">{{ number_format($total_paid, 2) }}</th>
                                <th colspan="2" style="text-align: right;">{{ number_format($total_balance, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @break

            @case('loans')
                <div class = "data">
                    <table class="table border-secondary table-sm mt-2">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Staff ID</th>
                                <th>Staff Name</th>
                                <th>Description</th>
                                <th style="text-align: right;">Amount</th>
                                <th style="text-align: right;">Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total_paid = 0;
                                $total_balance = 0;
                            @endphp
                            @foreach ($data as $key => $staff)
                                @php
                                    $total_paid += $staff->amount_paid;
                                    $balance = $staff->amount - $staff->total_amount_paid;
                                    $total_balance += $balance;
                                @endphp
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $staff->staff_number }}</td>
                                    <td>{{ $staff->fullname }}</td>
                                    <td>{{ $staff->description }}</td>
                                    <td style="text-align: right;">{{ number_format($staff->amount_paid, 2) }}</td>
                                    <td style="text-align: right;">{{ number_format($balance, 2) }}</td>
                                </tr> 
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" style="text-align: center">GRAND TOTAL</th>
                                <th colspan="3" style="text-align: right;">{{ number_format($total_paid, 2) }}</th>
                                <th colspan="2" style="text-align: right;">{{ number_format($total_balance, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @break
        
            @default
                <h5>No Report Select</h5>
        @endswitch
        @switch($report)
        
            @case('Bankers')
                <a href="{{ route('exprt_to_bank', [$date['month'], $date['year']]) }}" class="noprint btn btn-outline-dark">Export</a>
                @break

            @case('tier_1')
                <a href="{{ route('exprt_to_tier_1', [$date['month'], $date['year']]) }}" class="noprint btn btn-outline-dark">Export</a>
                @break

            @case('tier_2')
                <a href="{{ route('exprt_to_tier_2', [$date['month'], $date['year']]) }}" class="noprint btn btn-outline-dark">Export</a>
                @break

            @case('paye_tax')
                <a href="{{ route('exprt_to_paye_tax', [$date['month'], $date['year']]) }}" class="noprint btn btn-outline-dark">Export</a>
                @break

            @case('welfare')
                <a href="{{ route('exprt_to_welfare', [$date['month'], $date['year']]) }}" class="noprint btn btn-outline-dark">Export</a>
                @break

            @case('credit_union')
                <a href="{{ route('exprt_to_credit_union', [$date['month'], $date['year']]) }}" class="noprint btn btn-outline-dark">Export</a>
                @break

            @case('rent')
                <a href="{{ route('exprt_to_rent', [$date['month'], $date['year']]) }}" class="noprint btn btn-outline-dark">Export</a>
                @break

            @case('loans')
                <a href="{{ route('exprt_to_loans', [$date['month'], $date['year']]) }}" class="noprint btn btn-outline-dark">Export</a>
                @break

            @default
                
        @endswitch
        <button class="noprint btn btn-outline-dark" onclick="print_1()">Print</button>
		
    </body>
</html>

