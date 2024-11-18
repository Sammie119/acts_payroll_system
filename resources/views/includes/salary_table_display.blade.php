<table class="table border-secondary table-sm mt-2">
    <tr>
        <td style="width: 20%">Name: </td>
        <td style="width: 40%">{{ $staff->fullname }}</td>
        <td style="">Month: </td>
        <td style="" nowrap>{{ $pay->pay_month }}, {{ $pay->pay_year }}</td>
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
        <td style="">SSF Number: </td>
        <td style="">{{ $staff->ssnit_number }}</td>
    </tr>
    <tr>
        <td style="width: 20%" nowrap>Account No.: </td>
        <td style="width: 40%">{{ $staff->bank_account }}</td>
        <td style="" nowrap>Annual Salary:</td>
        <td style="">{{ number_format($pay->basic * 12, 2) }}</td>
    </tr>
</table>

@php
    $allowances = \App\Models\PayrollDependecy::where('id', $pay->depend_id)->first();
    $total_paid_loan = 0;
@endphp
<br>
<table class="table border-secondary table-sm mt-2">
    <tr style="border-top: 2px solid black; border-bottom: 2px solid black;">
        <th style="text-align: left; background: #eee">Item</th>
        <th style="text-align: left; background: #eee; padding-right: 10px;">Earnings</th>
        <th colspan="3" style="text-align: left; background: #eee; border-left: 2px solid black; padding-left: 10px;">Item</th>
        <th colspan="2" style="text-align: left; background: #eee">Deductions</th>
    </tr>
    <tr>
        <td nowrap>Basic Salary</td>
        <td nowrap style="text-align: right; padding-right: 10px;">{{ number_format($pay->basic, 2) }}</td>
        <td nowrap style="border-left: 2px solid black; padding-left: 10px;">Employee SSF</td>
        <td nowrap style=""></td>
        <td nowrap style=""></td>
        <td nowrap style="text-align: right">{{ number_format($allowances->employee_ssf, 2) }}</td>
        <td nowrap style=""></td>
    </tr>
    <tr>
        <td style=""></td>
        <td style="text-align: right; padding-right: 10px;">0.00</td>
        <td style="border-left: 2px solid black; padding-left: 10px;">Income Tax</td>
        <td style=""></td>
        <td style=""></td>
        <td style="text-align: right">{{ number_format($allowances->tax, 2) }}</td>
        <td style=""></td>
    </tr>
    <tr>
        <td colspan="2"><br></td>
        <td colspan="5" style="border-left: 2px solid black"><br></td>
    </tr>
    <tr style="border-top: 2px solid black; border-bottom: 2px solid black;">
        <th style="">Description</th>
        <th style="padding-right: 10px;">Amount</th>
        <th style="text-align: left; border-left: 2px solid black; padding-left: 10px;">Description</th>
        <th style="">Principal</th>
        <th style="">Refunded</th>
        <th style="">Deduction</th>
        <th style="">Balance</th>
    </tr>

    @if(!empty($allowances->incomes))
        @foreach ($allowances->incomes as $i => $incomes)
            <tr>
                <td nowrap>{{ $incomes }}</td>
                <td style="padding-right: 10px; text-align: right">{{ number_format($allowances->amount_incomes[$i], 2) }}</td>
                <td style="border-left: 2px solid black"></td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
            </tr>
        @endforeach
    @endif

    @if(!empty($allowances->deductions))
        @foreach ($allowances->deductions as $i => $deductions)
            <tr>
                <td colspan="2"></td>
                <td nowrap style="text-align: left; border-left: 2px solid black; padding-left: 10px;">{{ $deductions }}</td>
                <td style=""></td>
                <td style=""></td>
                <td style="text-align: right">{{ number_format($allowances->amount_deductions[$i], 2) }}</td>
                <td style=""></td>
            </tr>
        @endforeach
    @endif

    @if ($allowances->tier_3 > 0)
        <tr>
            <td colspan="2"></td>
            <td nowrap style="text-align: left; border-left: 2px solid black; padding-left: 10px;">Tier 3</td>
            <td style=""></td>
            <td style=""></td>
            <td style="text-align: right">{{ number_format($allowances->tier_3, 2) }}</td>
            <td style=""></td>
        </tr>
    @endif

    @if(!empty($allowances->loan_ids))
        @foreach ($allowances->loan_ids as $i => $loan_id)
            @php
                $paid_loan = \App\Models\LoanPayment::where('loan_pay_id', $loan_id)->first();
                $total_paid_loan += $paid_loan->amount_paid;
            @endphp
            <tr>
                <td colspan="2"></td>
                <td nowrap style="text-align: left; border-left: 2px solid black; padding-left: 10px;">{{ $paid_loan->loan->description }}</td>
                <td style="text-align: right">{{ number_format($paid_loan->amount, 2) }}</td>
                <td style="text-align: right">{{ number_format($paid_loan->total_amount_paid, 2) }}</td>
                <td style="text-align: right">{{ number_format($paid_loan->amount_paid, 2) }}</td>
                <td style="text-align: right">{{ number_format($paid_loan->amount - $paid_loan->total_amount_paid, 2) }}</td>
            </tr>
        @endforeach
    @endif

    <tr style="border-top: 2px solid black; border-bottom: 2px solid black;">
        <th nowrap>Total Earnings</th>
        <th style="padding-right: 10px; text-align: right">{{ number_format($pay->gross_income, 2) }}</th>
        <th nowrap style="text-align: left; border-left: 2px solid black; padding-left: 10px;">Total Deduction</th>
        <th style=""></th>
        <th style=""></th>
        <th style="text-align: right">{{ number_format(($staff->pay_tier2 == 1) ? (array_sum($allowances->amount_deductions ?? [0]) + $allowances->tax + $allowances->employee_ssf + $total_paid_loan + $allowances->tier_3) : (array_sum($allowances->amount_deductions ?? [0]) + $allowances->tax + $total_paid_loan + $allowances->tier_3), 2) }}</th>
        <th></th>
    </tr>

    <tr>
        <td colspan="2"><br></td>
        <td colspan="5" style="border-left: 2px solid black"><br></td>
    </tr>


    <tr>
        <td nowrap>Employer SSF</td>
        <td style="padding-right: 10px; text-align: right">{{ number_format($allowances->employer_ssf, 2) }}</td>
        <th nowrap style="text-align: left; border-left: 2px solid black; padding-left: 10px;">Net Pay</th>
        <td style=""></td>
        <td style=""></td>
        <th style="text-align: right">{{ number_format(($staff->pay_tier2 == 1) ? $pay->net_income - $allowances->tier_3 : ($pay->net_income - $allowances->tier_3) + $allowances->employee_ssf, 2) }}</th>
        <td style=""></td>
    </tr>
    <tr>
        <td nowrap>Total SSF</td>
        <td style="padding-right: 10px; text-align: right">{{ number_format(($staff->pay_tier2 == 1) ? $allowances->employer_ssf + $allowances->employee_ssf : 0, 2) }}</td>
        <td nowrap style="text-align: left; border-left: 2px solid black; padding-left: 10px;">Tax Relief</td>
        <td style=""></td>
        <td style=""></td>
        <td style="text-align: right">{{ number_format($allowances->tax_relief, 2) }}</td>
        <td style=""></td>
    </tr>

{{--    <tr>--}}
{{--        <td style="width: 20%">Income Tax</td>--}}
{{--        <td style="width: 40%"></td>--}}
{{--        <td style=" text-align:right; padding-right:20px">{{ number_format($allowances->tax, 2) }}</td>--}}
{{--        <td style=""></td>--}}
{{--    </tr>--}}

{{--    @if ($staff->pay_tier2 == 1)--}}
{{--        <tr>--}}
{{--            <td style="width: 20%">Employee SSF</td>--}}
{{--            <td style="width: 40%"></td>--}}
{{--            <td style=" text-align:right; padding-right:20px">{{ number_format($allowances->employee_ssf, 2) }}</td>--}}
{{--            <td style=""></td>--}}
{{--        </tr>--}}
{{--    @endif--}}

</table>
