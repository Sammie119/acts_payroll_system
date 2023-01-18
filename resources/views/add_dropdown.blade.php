@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-10">
                            @isset($dropdown)
                                {{ __('Edit Dropdown') }}
                            @else
                                {{ __('Add New Dropdown') }} 
                            @endisset
                        </div>
                        <div class="col-2">
                            <a class="btn btn-secondary btn-sm float-end" href="{{ url()->previous() }}">Back</a> 
                        </div>
                    </div>
                </div>
                

                <div class="card-body">
                    @isset($dropdown->dropdown_id)
                        <form method="POST" action="{{ route('update_dropdown') }}">
                    @else
                        <form method="POST" action="{{ route('store_dropdown') }}">
                    @endisset
                    
                        @csrf

                        @isset($dropdown->dropdown_id)
                            <input type="hidden" name="id" value="{{ $dropdown->dropdown_id }}">
                        @endisset

                        <div class="row mb-3">
                            <label for="dropdown_name" class="col-md-4 col-form-label text-md-end">{{ __('Dropdown Name') }}</label>

                            <div class="col-md-6">
                                <input id="dropdown_name" type="text" class="form-control @error('dropdown_name') is-invalid @enderror" name="dropdown_name" value="{{ (isset($dropdown->dropdown_id)) ? $dropdown->dropdown_name : old('dropdown_name') }}" required autocomplete="dropdown_name" autofocus>

                                @error('dropdown_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="category_id" class="col-md-4 col-form-label text-md-end">{{ __('Dropdown Category') }}</label>

                            <div class="col-md-6">
                                <select id="category_id" class="form-control @error('category_id') is-invalid @enderror" name="category_id" required>
                                    <option value="" disabled selected>--Select Category--</option>
                                    <option @if (isset($dropdown->dropdown_id) && $dropdown->category_id === 1) selected @endif value="1">Allowance</option>
                                    <option @if (isset($dropdown->dropdown_id) && $dropdown->category_id === 2) selected @endif value="2">Deduction</option>
                                </select>

                                @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="category_id" class="col-md-4 col-form-label text-md-end">{{ __('Taxable') }}</label>

                            <div class="col-md-6">
                                <input class="form-check-input @error('taxable') is-invalid @enderror" name="taxable" type="checkbox" value="1" id="taxable_check" style="height: 30px; width: 30px" @if (isset($dropdown->dropdown_id) && $dropdown->taxable === 1) checked @endif>
                            </div>

                            @error('taxable')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" onclick="taxableCheck()">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    function taxableCheck() {
        let value = document.getElementById('category_id').value;
        if(document.getElementById("taxable_check").checked){
            if(value == 2 && document.getElementById("taxable_check").checked){
                alert('Deductions Cannot be Taxed!!!!');
                document.getElementById("taxable_check").checked = false;
                return false;
            }
        }
    }
</script>
