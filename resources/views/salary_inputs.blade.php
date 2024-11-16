@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-10">
                            <h5>{{ __('Salary Inputs for '. $staff->fullname) }}</h5>
                        </div>
                        <div class="col-2">
                            <a class="btn btn-secondary btn-sm float-end" href="{{ url()->previous() }}">Back</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="store_payroll">
                        @csrf

                        @isset($loan)
                            <input type="hidden" name="id" value="{{ $loan->loan_id }}">
                        @endisset

                        <div class="row mb-3">
                            <label for="staffname" class="col-md-3 col-form-label text-md-end">{{ __('Staff Name') }}</label>

                            <div class="col-md-7">
                                <input id="staffname" type="text" list="staff_name" class="form-control @error('staffname') is-invalid @enderror" name="staffname" value="{{ $staff->fullname }}" required autocomplete="staffname">
                                <input type="hidden" name="staff_id" value="{{ $staff->staff_id }}">
                                @error('staffname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="position" class="col-md-3 col-form-label text-md-end">{{ __('Position') }}</label>

                            <div class="col-md-7">
                                <input id="position" type="text" name="position" class="form-control" value="{{ $staff->position }}" required autocomplete="position">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="salary" class="col-md-3 col-form-label text-md-end">{{ __('Basic Salary') }}</label>

                            <div class="col-md-7">
                                <input id="salary" type="text" name="basic_salary" class="form-control" value="{{ number_format($salary->salary, 2, '.', '') }}" required autocomplete="salary">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="tax" class="col-md-3 col-form-label text-md-end">{{ __('Income/PAYE Tax') }}</label>

                            <div class="col-md-7">
                                <input id="tax" type="number" min="0" step="0.01" name="tax" readonly class="form-control" value="{{ number_format(getTax($salary->salary, $staff->staff_id), 2, '.', '') }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="tax_relief" class="col-md-3 col-form-label text-md-end">{{ __('Tax Relief') }}</label>

                            <div class="col-md-7">
                                <input id="tax_relief" type="number" min="0" step="0.01" name="tax_relief" readonly class="form-control" value="{{ number_format(getTaxRelief($staff->staff_id), 2, '.', '') }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="tier_3" class="col-md-3 col-form-label text-md-end">{{ __('Tier 3') }}</label>

                            <div class="col-md-7">
                                <input id="tier_3" type="number" min="0" step="0.01" name="tier_3" readonly class="form-control" value="{{ number_format(getTierThree($staff->staff_id, $salary->salary), 2, '.', '') }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="employer_ssf" class="col-md-3 col-form-label text-md-end">{{ __('Employer SSF') }}</label>

                            <div class="col-md-7">
                                <input id="employer_ssf" type="number" min="0" step="0.01" name="employer_ssf" readonly class="form-control" value="{{ number_format(($staff->age >= 60) ? 0 : getSsfEmployer($salary->salary), 2, '.', '') }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="employee_ssf" class="col-md-3 col-form-label text-md-end">{{ __('SSF Employee') }}</label>

                            <div class="col-md-7">
                                <input id="employee_ssf" type="number" min="0" step="0.01" name="employee_ssf" readonly class="form-control" value="{{ number_format(($staff->age >= 60) ? 0 : getSsfEmployee($salary->salary), 2, '.', '') }}">
                            </div>
                        </div>

                        <hr width="104%" style="margin-left: -15px; background: #bbb">
                        <div class="row mb-4" style="width: 70%; margin-left: 15%">
                            <div class="col-6">
                                <label for="month" class="col-form-label text-md-end">{{ __('Salary Month') }}</label>

                                <div class="">
                                    <select class="form-control" name="month" required>
                                        <option value="" selected disabled>--Select Month--</option>
                                        <option {{ (date('m') === '01') ? 'selected' : null }}>January</option>
                                        <option {{ (date('m') === '02') ? 'selected' : null }}>February</option>
                                        <option {{ (date('m') === '03') ? 'selected' : null }}>March</option>
                                        <option {{ (date('m') === '04') ? 'selected' : null }}>April</option>
                                        <option {{ (date('m') === '05') ? 'selected' : null }}>May</option>
                                        <option {{ (date('m') === '06') ? 'selected' : null }}>June</option>
                                        <option {{ (date('m') === '07') ? 'selected' : null }}>July</option>
                                        <option {{ (date('m') === '08') ? 'selected' : null }}>August</option>
                                        <option {{ (date('m') === '09') ? 'selected' : null }}>September</option>
                                        <option {{ (date('m') === '10') ? 'selected' : null }}>October</option>
                                        <option {{ (date('m') === '11') ? 'selected' : null }}>November</option>
                                        <option {{ (date('m') === '12') ? 'selected' : null }}>December</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label for="year" class="col-form-label text-md-end">{{ __('Salary Year') }}</label>

                                <div class="">
                                    <select class="form-control" name="year" required>
                                        <option value="" selected disabled>--Select Year--</option>
                                            <?php
                                            for($i = 2022 ; $i <= date('Y'); $i++){
                                                $thisYear = (date('Y') == $i) ? 'selected' : null;
                                                echo "<option ". $thisYear .">$i</option>";
                                            }
                                            ?>
                                    </select>
                                </div>
                            </div>

                        </div>

                        @include('includes.salary_input_display', [
                            'header' => 'Allowances',
                            'first_class' => 'add-all-allowances', //Main container
                            'second_class' => 'add-allowance',
                            'no_data' => 'allowance', //No data found disappear
                        ])

                        <hr width="104%" style="margin-left: -15px; background: #bbb">

                        @include('includes.salary_input_display', [
                            'header' => 'Deductions',
                            'first_class' => 'add-all-deduction', //Main container
                            'second_class' => 'add-deduction',
                            'no_data' => 'deduction', //No data found disappear
                            ])

                        <hr width="104%" style="margin-left: -15px; background: #bbb">

                        <div class="row mb-0">
                            {{-- <div class="col-md-6 offset-md-4"> --}}
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>
                            {{-- </div> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    window.onload = function(){
        @include('includes.salary_input',[
            'first_class' => 'add-all-allowances', //Main container
            'second_class' => 'add-allowance',
            'first_input' => 'incomes[]',
            'second_input' => 'amount_incomes[]',
            'third_input' => 'rate_incomes[]',
            'no_data' => 'allowance', //No data found disappear
        ])

        @include('includes.salary_input',[
            'first_class' => 'add-all-deduction', //Main container
            'second_class' => 'add-deduction',
            'first_input' => 'deductions[]',
            'second_input' => 'amount_deductions[]',
            'third_input' => 'rate_deductions[]',
            'no_data' => 'deduction', //No data found disappear
        ])
    };
</script>
