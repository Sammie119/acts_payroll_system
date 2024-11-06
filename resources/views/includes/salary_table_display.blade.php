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
                <td style="width: 20%; text-align:right; padding-right:20px">{{ number_format($allowances->amount_incomes[$i], 2) }}</td>
                <td style="width: 20%;"></td>
            </tr>
        @endforeach
    @endif

    <tr>
        <th style="width: 20%">Gross Pay</th>
        <td style="width: 40%"></td>
        <td style="width: 20%;"></td>
        <th style="width: 20%; text-align:right; padding-right:20px">{{ number_format($pay->gross_income, 2) }}</th>
    </tr>
    <tr>
        <td colspan="5"><br></td>
    </tr>

    @if ($staff->age <= 60)
        <tr>
            <td style="width: 20%">Employer SSF</td>
            <td style="width: 40%"></td>
            <td style="width: 20%; text-align:right; padding-right:20px">{{ number_format($allowances->employer_ssf, 2) }}</td>
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
        <td style="width: 20%; text-align:right; padding-right:20px">{{ number_format($allowances->tax, 2) }}</td>
        <td style="width: 20%;"></td>
    </tr>

    @if ($staff->age <= 60)
        <tr>
            <td style="width: 20%">Employee SSF</td>
            <td style="width: 40%"></td>
            <td style="width: 20%; text-align:right; padding-right:20px">{{ number_format($allowances->employee_ssf, 2) }}</td>
            <td style="width: 20%;"></td>
        </tr>
    @endif

    @if(!empty($allowances->deductions))
        @foreach ($allowances->deductions as $i => $deductions)
            <tr>
                <td style="width: 20%" nowrap>{{ $deductions }}</td>
                <td style="width: 40%"></td>
                <td style="width: 20%; text-align:right; padding-right:20px">{{ number_format($allowances->amount_deductions[$i], 2) }}</td>
                <td style="width: 20%;"></td>
            </tr>
        @endforeach
    @endif

    @if ($allowances->tier_3 > 0)
        <tr>
            <td style="width: 20%" nowrap colspan="2">Tier 3</td>
            {{-- <td style="width: 40%"></td> --}}
            <td style="width: 20%; text-align:right; padding-right:20px">{{ number_format($allowances->tier_3, 2) }}</td>
            <td style="width: 20%;"></td>
        </tr>
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
                <td style="width: 20%; text-align:right; padding-right:20px">{{ number_format($paid_loan->amount_paid, 2) }}</td>
                <td style="width: 20%;"></td>
            </tr>
        @endforeach
    @endif

    <tr>
        <th style="width: 20%">Total Deduction</th>
        <td style="width: 40%"></td>
        <td style="width: 20%;"></td>
        <th style="width: 20%; text-align:right; padding-right:20px">{{ number_format(($staff->age <= 60) ? (array_sum($allowances->amount_deductions ?? [0]) + $allowances->tax + $allowances->employee_ssf + $total_paid_loan + $allowances->tier_3) : (array_sum($allowances->amount_deductions ?? [0]) + $allowances->tax + $total_paid_loan + $allowances->tier_3), 2) }}</th>
    </tr>
    <tr>
        <td colspan="5"><br></td>
    </tr>
    <tr>
        <th style="width: 20%">Net Pay</th>
        <td style="width: 40%"></td>
        <td style="width: 20%;"></td>
        <th style="width: 20%; text-align:right; padding-right:20px">{{ number_format(($staff->age <= 60) ? $pay->net_income - $allowances->tier_3 : ($pay->net_income - $allowances->tier_3) + $allowances->employee_ssf, 2) }}</th>
    </tr>
    <tr>
        <td colspan="5"><br></td>
    </tr>
    <tr>
        <td style="width: 20%">Total SSF</td>
        <th style="width: 40%">{{ number_format(($staff->age <= 60) ? $allowances->employer_ssf + $allowances->employee_ssf : 0, 2) }}</th>
        <td style="width: 20%;">Tax Relief</td>
        <th style="width: 20%; text-align:right; padding-right:20px">{{ number_format($allowances->tax_relief, 2) }}</th>
    </tr>

</table>
