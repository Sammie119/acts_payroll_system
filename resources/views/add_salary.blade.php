@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    
                    @isset($salary)
                        <h5>{{ __('Edit salary') }}</h5>
                    @else
                        <h5>{{ __('Add salary') }}</h5>  
                    @endisset
                </div>

                <div class="card-body">
                    @isset($salary)
                        <form method="POST" action="update_salary">
                    @else
                        <form method="POST" action="store_salary">  
                    @endisset
                    
                        @csrf
                        @isset($salary)
                            <input type="hidden" name="id" value="{{ $salary->salary_id }}">

                            <div class="row mb-3" style="font-weight: bold">
                                <label class="col-md-5 col-form-label text-md-end">{{ __('Staff Name') }}</label>

                                <label class="col-md-3 col-form-label text-md-end">{{ __('Basic Salary') }}</label>

                                <label class="col-md-3 col-form-label text-md-end">{{ __('Tax Relief') }}</label>
                            </div>

                            <div class="row mb-3">
                                <label class="col-md-5 col-form-label text-md-end">{{ $salary->staff->fullname }}</label>

                                <div class="col-md-3">
                                    <input type="number" step="0.01" min="1" class="form-control" name="salary" value="{{ $salary->salary }}" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" step="0.01" min="0" class="form-control" name="tax_relief" value="{{ $salary->tax_relief }}" required>
                                </div>
                            </div>

                        @else
                            <div class="row mb-3" style="font-weight: bold">
                                <label class="col-md-5 col-form-label text-md-end">{{ __('Staff Name') }}</label>

                                <label class="col-md-3 col-form-label text-md-end">{{ __('Basic Salary') }}</label>

                                <label class="col-md-3 col-form-label text-md-end">{{ __('Tax Relief') }}</label>
                            </div>
                            @foreach ($staff as $staff)
                                <div class="row mb-3">
                                    <label class="col-md-5 col-form-label text-md-end">{{ $staff->fullname }}</label>

                                    <input type="hidden" name="staff_id[]" value="{{ $staff->staff_id }}">

                                    <div class="col-md-3">
                                        <input type="number" step="0.01" min="1" class="form-control" name="salary[]" value="{{ isset($salary) ? $salary->firstname : null }}" required>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" step="0.01" min="0" class="form-control" name="tax_relief[]" value="{{ isset($salary) ? $salary->firstname : null }}" required>
                                    </div>
                                </div>
                            @endforeach
                        @endisset                    

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

