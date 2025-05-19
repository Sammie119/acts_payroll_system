@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-10">
                            @isset($grade)
                                <h5>{{ __('Edit Grade') }}</h5>
                            @else
                                <h5>{{ __('New Grade') }}</h5>
                            @endisset
                        </div>
                        <div class="col-2">
                            <a class="btn btn-secondary btn-sm float-end" href="{{ url()->previous() }}">Back</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @isset($grade)
                        <form method="POST" action="/grades/edit/grade">
                    @else
                        <form method="POST" action="/grades/store">
                    @endisset

                        @csrf

                        @isset($grade)
                            <input type="hidden" name="id" value="{{ $grade->id }}">
                        @endisset

                        <div class="row mb-3">
                            <label for="name" class="col-md-3 col-form-label text-md-end">{{ __('Name') }}</label>
                            <div class="col-md-7">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ isset($grade) ? $grade->name : old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="description" class="col-md-3 col-form-label text-md-end">{{ __('Description') }}</label>
                            <div class="col-md-7">
                                <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ isset($grade) ? $grade->description : old('description') }}" required autocomplete="description" autofocus>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="trans_amount" class="col-md-3 col-form-label text-md-end">{{ __('Transportation') }}</label>
                            <div class="col-md-7">
                                <input id="trans_amount" type="number" min="0" step="0.01" name="trans_amount" class="form-control @error('trans_amount') is-invalid @enderror" value="{{ isset($grade) ? $grade->trans_amount : old('trans_amount') }}" required autocomplete="trans_amount">
                                @error('trans_amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="base_salary" class="col-md-3 col-form-label text-md-end">{{ __('Base Salary') }}</label>
                            <div class="col-md-7">
                                <input id="base_salary" type="number" min="0" step="0.01" name="base_salary" class="form-control @error('base_salary') is-invalid @enderror" value="{{ isset($grade) ? $grade->base_salary : old('base_salary') }}" required autocomplete="base_salary">
                                @error('base_salary')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        @empty($grade)
                            <div class="row mb-3">
                                <label for="notch_number" class="col-md-3 col-form-label text-md-end">{{ __('Notch Levels') }}</label>
                                <div class="col-md-7">
                                    <input id="notch_number" type="number" min="0" step="1" max="25" name="notch_number" class="form-control @error('notch_number') is-invalid @enderror" value="5" required autocomplete="notch_number">
                                    @error('notch_number')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>
                        @endempty

                        <div class="row mb-3">
                            <label for="notch_percentage" class="col-md-3 col-form-label text-md-end">{{ __('Notch level salary increment (%)') }}</label>
                            <div class="col-md-7">
                                <input id="notch_percentage" type="number" min="0" step="1" max="100" name="notch_percentage" class="form-control @error('notch_percentage') is-invalid @enderror" value="20" required autocomplete="notch_percentage">
                                @error('notch_percentage')
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
