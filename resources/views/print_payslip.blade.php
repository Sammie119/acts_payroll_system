<!DOCTYPE>
 <html>

    <title>ACTS_Payslip_{{ $staff->staff_number }}_{{ $staff->firstname }}</title>
    <link rel="shortcut icon" href="{{ asset('build/assets/images/smmie_logo.ico') }}" type="image/ico">
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
            <img class="center" src="{{ asset('build/assets/images/acts_logo.jpg') }}" width="300px" height="150px" alt="ACTS_logo">
            <div id="logo" style="margin-top: -2%">
                <h5 id="logo-text">Payslip</h5>
            </div>
        </header>

        <div class = "data">
            <div class="watermark"><img src="{{ asset('build/assets/images/acts_logo_alone.jpg') }}" width="300px" height="400px"></div>

            @include('./includes/salary_table_display')

        </div>


        <button class="noprint btn btn-outline-dark" onclick="print_1()"> &#128438; Print</button>

    </body>
</html>

