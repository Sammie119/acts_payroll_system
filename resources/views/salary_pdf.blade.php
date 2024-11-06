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
//            dd($payment);
        @endphp

        @if(empty($staff->email) && $staff)
            <div class="page-break" style="width: 100%;" >
                <header id="header">
                    <img class="center" src="{{ public_path('build/assets/images/acts_logo.jpg') }}" width="300px" height="150px" alt="ACTS_logo">
                    <div id="logo" style="margin-top: -2%">
                        <h5 id="logo-text">Payslip</h5>
                    </div>
                </header>

                <div class = "data">
                    <div class="watermark"><img src="{{ public_path('build/assets/images/acts_logo_alone.jpg') }}" width="300px" height="400px"></div>

                    @include('./includes/salary_table_display')

                </div>
            </div>
        @endempty

        @isset($request)
            <div style="width: 100%;" >
                <header id="header">
                    <img class="center" src="{{ public_path('build/assets/images/acts_logo.jpg') }}" width="300px" height="150px" alt="ACTS_logo">
                    <div id="logo" style="margin-top: -2%">
                        <h5 id="logo-text">Payslip</h5>
                    </div>
                </header>

                <div class = "data">
                    <div class="watermark"><img src="{{ public_path('build/assets/images/acts_logo_alone.jpg') }}" width="300px" height="400px"></div>

                    @include('./includes/salary_table_display')

                </div>
            </div>
        @endisset

    @endforeach
</body>

</html>

