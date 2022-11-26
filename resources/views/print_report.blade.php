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
                                    $salary = \App\Models\Payroll::select('net_income')->where([
                                            ['staff_id', $staff->staff_id],
                                            ['pay_month', $date['month']],
                                            ['pay_year', $date['year']]
                                        ])->first()->net_income;

                                    $total_salary += $salary;
                                @endphp
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $staff->fullname }}</td>
                                    <td>{{ $staff->banker }}</td>
                                    <td>{{ $staff->bank_branch }}</td>
                                    <td>{{ $staff->bank_account }}</td>
                                    <td style="text-align: right;">{{ number_format($salary, 2) }}</td>
                                </tr> 
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" style="text-align: center">GRAND TOTAL</th>
                                <th colspan="4" style="text-align: right;">{{ number_format($total_salary, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @break
        
            @default
                
        @endswitch
        
        
        <button class="noprint btn btn-outline-dark" onclick="print_1()"> &#128438; Print</button>
		
    </body>
</html>

