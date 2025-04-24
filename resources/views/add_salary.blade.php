@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-10">
                            @isset($salary)
                                <h5>{{ __('Edit salary') }}</h5>
                            @else
                                <h5>{{ __('Add salary') }}</h5>
                            @endisset
                        </div>
                        <div class="col-2">
                            <a class="btn btn-secondary btn-sm float-end" href="{{ url()->previous() }}">Back</a>
                        </div>
                    </div>
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

                                <label class="col-md-2 col-form-label text-md-end">{{ __('Basic Salary') }}</label>

                                <label class="col-md-2 col-form-label text-md-end">{{ __('Tax Relief') }}</label>

                                <label class="col-md-2 col-form-label text-md-end">{{ __('Tier 3 (%)') }}</label>
                            </div>

                            <div class="row mb-3">
                                <label class="col-md-5 col-form-label text-md-end">{{ $salary->staff->fullname }}</label>

                                <div class="col-md-2">
                                    <input type="number" step="0.01" min="1" class="form-control @error('salary') is-invalid @enderror" name="salary" value="{{ $salary->salary }}" required>

                                    @error('salary')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <input type="number" step="0.01" min="0" class="form-control @error('tax_relief') is-invalid @enderror" name="tax_relief" value="{{ $salary->tax_relief }}" required>

                                    @error('tax_relief')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <input type="number" id="tier_3" onchange="(checkValue(this))" step="0.01" min="0" class="form-control @error('tier_3') is-invalid @enderror" name="tier_3" value="{{ $salary->tier_3 }}" >

                                    @error('tier_3')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        @else
                            <div class="row mb-3">
                                <label class="col-md-5 col-form-label text-md-end">Increase Salary by a Percentage (%)</label>

                                <div class="col-md-6">
                                    <input type="number" step="0.01" min="0" class="form-control @error('salary_percentage') is-invalid @enderror" name="salary_percentage" value="{{old('salary_percentage')}}">
                                    @error('salary_percentage')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3" style="font-weight: bold">
                                <label class="col-md-5 col-form-label text-md-end">{{ __('Staff Name') }}</label>

                                <label class="col-md-2 col-form-label text-md-end">{{ __('Basic Salary') }}</label>

                                <label class="col-md-2 col-form-label text-md-end">{{ __('Tax Relief') }}</label>

                                <label class="col-md-2 col-form-label text-md-end">{{ __('Tier 3 (%)') }}</label>
                            </div>
                            @foreach ($staff as $staff)
                                @php
                                    $sal = App\Models\SetupSalary::where('staff_id', $staff->staff_id)->orderByDesc('salary_id')->first();
                                @endphp
                                <div class="row mb-3">
                                    <label class="col-md-5 col-form-label text-md-end">{{ $staff->fullname }} - {{ $staff->staff_number }}</label>

                                    <input type="hidden" name="staff_id[]" value="{{ $staff->staff_id }}">

                                    <div class="col-md-2">
                                        <input type="number" step="0.01" min="1" class="form-control" name="salary[]" value="{{ (isset($sal->salary_id)) ? $sal->salary : '0.00' }}" required>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" step="0.01" min="0" class="form-control" name="tax_relief[]" value="{{ (isset($sal->salary_id)) ? $sal->tax_relief : '0.00' }}" required>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" id="tier_3" step="0.01" min="0" class="form-control" name="tier_3[]" value="{{ (isset($sal->salary_id)) ? $sal->tier_3 : '0.00' }}" onchange="(checkValue(this))" required>
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

<script>

    function checkValue(e)
    {
        if(e.value > 16.5){
            alert("Tier 3 cannot be greater than 16.5%");
            // console.log(e);
            e.value = 0;
            return false;
        }
    }

</script>

