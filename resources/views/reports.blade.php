@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Reports') }}</h5>
                </div>

                <div class="card-body">
                    <form action="generate_report" method="post">
                        @csrf
                        <div class="row mb-3">
                            <label for="report_type" class="col-md-3 col-form-label text-md-end">{{ __('Report Type') }}</label>
    
                            <div class="col-md-7">
                                <select class="form-control" name="report_type" required autofocus>
                                    <option value="" selected disabled>--Select--</option>
                                    <option value="bank_doc">Salaries</option>
                                    <option value="tier_1">Tier 1</option>
                                    <option value="tier_2">Tier 2</option>
                                    <option value="contribute">Contributions</option>
                                    <option value="credit_union">Credit Union</option>
                                </select>                       
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="report_month" class="col-md-3 col-form-label text-md-end">{{ __('Report Month') }}</label>
    
                            <div class="col-md-7">
                                <select class="form-control" name="report_month" required>
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

                        <div class="row mb-3">
                            <label for="report_year" class="col-md-3 col-form-label text-md-end">{{ __('Report Year') }}</label>
    
                            <div class="col-md-7">
                                <select class="form-control" name="report_year" required>
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
