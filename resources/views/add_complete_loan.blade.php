@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-10">
                            <h5>{{ __('Manually Complete Loan') }}</h5>
                        </div>
                        <div class="col-2">
                            <a class="btn btn-secondary btn-sm float-end" href="{{ url()->previous() }}">Back</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="/complete_loan_store">
                        @csrf

                        <input type="hidden" name="loan_id" value="{{ $loan->loan_id }}" >

                        <div class="row mb-3">
                            <label for="staffname" class="col-md-3 col-form-label text-md-end">{{ __('Staff Name') }}</label>

                            <div class="col-md-7">
                                <input type="hidden" value="{{ $loan->staff_id }}" name="staff_id">
                                <input id="staffname" type="text" class="form-control @error('staffname') is-invalid @enderror" value="{{ \App\Models\VWStaff::select('fullname')->where('staff_id', $loan->staff_id)->first()->fullname }}" readonly>

                                @error('staffname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="description" class="col-md-3 col-form-label text-md-end">{{ __('Loan Description') }}</label>

                            <div class="col-md-7">
                                <select id="description" class="form-control @error('description') is-invalid @enderror" name="description" required>
                                    <option>{{$loan->description}}</option>
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
                                <input id="amount" type="number" name="amount" class="form-control" value="{{ $loan->amount }}" readonly >

                                @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="amount_per_month" class="col-md-3 col-form-label text-md-end">{{ __('Monthly Payment') }}</label>

                            <div class="col-md-7">
                                <input id="amount_per_month" type="number" min="1" step="0.01" class="form-control" name="monthly_payment" value="{{ $loan->amount_per_month }}" readonly>

                                @error('amount_per_month')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="amount_paid" class="col-md-3 col-form-label text-md-end">{{ __('Total Amount Paid') }}</label>

                            <div class="col-md-7">
                                <input id="amount_paid" type="number" class="form-control" name="amount_paid" value="{{ $loan_payment->total_amount_paid }}" readonly>
                                <input type="hidden" name="amount_left" value="{{ $loan->amount - $loan_payment->total_amount_paid }}">

                                @error('amount_paid')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="amount_paid" class="col-md-3 col-form-label text-md-end">{{ __('Remaining Months') }}</label>

                            <div class="col-md-7">
                                <input id="months_left" type="number" class="form-control" name="months_left" value="{{ $loan->number_of_months - $loan_payment->months_paid }}" readonly>
                                <input type="hidden" class="form-control" name="months_paid" value="{{ $loan_payment->months_paid }}">

                                @error('amount_paid')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="amount_paid" class="col-md-3 col-form-label text-md-end">{{ __('Please give Reason(s)') }}</label>

                            <div class="col-md-7">
                                <textarea id="reason" rows="5" class="form-control" name="reason" required ></textarea>

                                @error('reason')
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
