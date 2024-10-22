@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-10">
                            @isset($loan)
                                <h5>{{ __('Edit Loan') }}</h5>
                            @else
                                <h5>{{ __('New Loan') }}</h5>
                            @endisset
                        </div>
                        <div class="col-2">
                            <a class="btn btn-secondary btn-sm float-end" href="{{ url()->previous() }}">Back</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @isset($loan)
                        <form method="POST" action="update_loan">
                    @else
                        <form method="POST" action="store_loan">
                    @endisset

                        @csrf

                        @isset($loan)
                            <input type="hidden" name="id" value="{{ $loan->loan_id }}">
                        @endisset

                        <div class="row mb-3">
                            <label for="staffname" class="col-md-3 col-form-label text-md-end">{{ __('Staff Name') }}</label>

                            <div class="col-md-7">
                                <input id="staffname" type="text" list="staff_name" class="form-control @error('staffname') is-invalid @enderror" name="staffname" value="{{ isset($loan) ? \App\Models\VWStaff::select('fullname')->where('staff_id', $loan->staff_id)->first()->fullname : old('staffname') }}" required autocomplete="staffname" autofocus>

                                @error('staffname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <datalist id="staff_name">
                                @forelse (\App\Models\VWStaff::orderBy('fullname')->get() as $name)
                                    <option>{{ $name->fullname }}</option>
                                @empty
                                    <option value="" disabled selected>No Data Found</option>
                                @endforelse
                            </datalist>
                        </div>

                        {{-- <div class="row mb-3">
                            <label for="position" class="col-md-3 col-form-label text-md-end">{{ __('Position') }}</label>

                            <div class="col-md-3">
                                <input id="position" type="text" class="form-control @error('position') is-invalid @enderror" name="position" value="{{ isset($loan) ? $loan->position : old('position') }}" readonly autocomplete="position" onchange="Javascript:myAgeValidation()">
                            </div>

                            <label for="salary" class="col-md-2 col-form-label text-md-end">{{ __('Basic Salary') }}</label>

                            <div class="col-md-2">
                                <input id="salary" type="text" class="form-control" name="salary" value="{{ isset($loan) ? $loan->salary : old('salary') }}" readonly>
                            </div>
                        </div> --}}

                        <div class="row mb-3">
                            <label for="description" class="col-md-3 col-form-label text-md-end">{{ __('Loan Description') }}</label>

                            <div class="col-md-7">
                                <select id="description" class="form-control @error('description') is-invalid @enderror" name="description" required>
                                    <option value="" selected disabled>--Select--</option>
                                    <option @if (isset($loan) && $loan->description === "Emergency Loan") selected @endif>Emergency Loan</option>
                                    <option @if (isset($loan) && $loan->description === "Rent Advance") selected @endif>Rent Advance</option>
                                    <option @if (isset($loan) && $loan->description === "Credit Union") selected @endif>Credit Union</option>
                                    <option @if (isset($loan) && $loan->description === "Credit Union Hire Purchase") selected @endif>Credit Union Hire Purchase</option>
                                    <option @if (isset($loan) && $loan->description === "Welfare Loan") selected @endif>Welfare Loan</option>
                                </select>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="amount" class="col-md-3 col-form-label text-md-end">{{ __('Loan Amount') }}</label>

                            <div class="col-md-7">
                                <input id="amount" type="number" min="0" step="0.01" name="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ isset($loan) ? $loan->amount : old('amount') }}" required autocomplete="amount">

                                @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="amount_per_month" class="col-md-3 col-form-label text-md-end">{{ __('Amount Per Month') }}</label>

                            <div class="col-md-3">
                                <input id="amount_per_month" type="number" min="1" step="0.01" class="form-control @error('amount_per_month') is-invalid @enderror" name="amount_per_month" value="{{ isset($loan) ? $loan->amount_per_month : old('amount_per_month') }}" required autocomplete="amount_per_month">

                                @error('amount_per_month')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <label for="number_of_months" class="col-md-2 col-form-label text-md-end">{{ __('Duration') }}</label>

                            <div class="col-md-2">
                                <input id="number_of_months" type="number" min="1" step="1" class="form-control @error('number_of_months') is-invalid @enderror" name="number_of_months" value="{{ isset($loan) ? $loan->number_of_months : old('number_of_months') }}" required>

                                @error('number_of_months')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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
