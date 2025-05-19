@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-10">
                            <h5>{{ __('Edit Notch') }}</h5>
                        </div>
                        <div class="col-2">
                            <a class="btn btn-secondary btn-sm float-end" href="{{ url()->previous() }}">Back</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="/notches/edit/update">

                        @csrf

                        <input type="hidden" name="id" value="{{ $notch->id }}">
                        <input type="hidden" name="salary_grade_id" value="{{ $notch->salary_grade_id}}">

                        <div class="row mb-3">
                            <label for="grade" class="col-md-3 col-form-label text-md-end">{{ __('Grade') }}</label>
                            <div class="col-md-7">
                                <input id="grade" type="text" class="form-control @error('grade') is-invalid @enderror" name="grade" value="{{ $notch->grade->name }}" readonly autocomplete="grade" autofocus>
                                @error('grade')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="notch_level" class="col-md-3 col-form-label text-md-end">{{ __('Notch Level') }}</label>
                            <div class="col-md-7">
                                <input id="notch_level" type="text" class="form-control @error('notch_level') is-invalid @enderror" name="notch_level" value="{{ $notch->notch_level }}" readonly autocomplete="notch_level" autofocus>
                                @error('notch_level')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="description" class="col-md-3 col-form-label text-md-end">{{ __('Description') }}</label>
                            <div class="col-md-7">
                                <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ $notch->description }}" required autocomplete="description" autofocus>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="amount" class="col-md-3 col-form-label text-md-end">{{ __('Amount') }}</label>
                            <div class="col-md-7">
                                <input id="amount" type="number" min="0" step="0.01" name="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ $notch->amount }}" required autocomplete="amount">
                                @error('amount')
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
