@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    
                    @isset($staff)
                        <h5>{{ __('Edit Staff') }}</h5>
                    @else
                        <h5>{{ __('Add Staff') }}</h5>  
                    @endisset
                </div>

                <div class="card-body">
                    @isset($staff)
                        <form method="POST" action="update_staff">
                    @else
                        <form method="POST" action="store_staff">  
                    @endisset
                    
                        @csrf
                        @php
                            $staff_number = sprintf("%03d", Illuminate\Support\Facades\DB::table('staff')->count() + 1);
                        @endphp

                        @isset($staff)
                            <input type="hidden" name="id" value="{{ $staff->staff_id }}">
                        @endisset

                        <div class="row mb-3">
                            <label for="staff_number" class="col-md-3 col-form-label text-md-end">{{ __('Staff Number') }}</label>

                            <div class="col-md-7">
                                <input id="staff_number" type="text" class="form-control @error('staff_number') is-invalid @enderror" name="staff_number" value="{{ isset($staff) ? $staff->staff_number : "AS".$staff_number }}" readonly autocomplete="staff_number">

                                @error('staff_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="firstname" class="col-md-3 col-form-label text-md-end">{{ __('First Name') }}</label>

                            <div class="col-md-7">
                                <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ isset($staff) ? $staff->firstname : old('firstname') }}" required autocomplete="firstname" autofocus>

                                @error('firstname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="othernames" class="col-md-3 col-form-label text-md-end">{{ __('Other Names') }}</label>

                            <div class="col-md-7">
                                <input id="othernames" type="text" class="form-control @error('othernames') is-invalid @enderror" name="othernames" value="{{ isset($staff) ? $staff->othernames : old('othernames') }}" required autocomplete="othernames">

                                @error('othernames')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="date_of_birth" class="col-md-3 col-form-label text-md-end">{{ __('Date of Birth') }}</label>

                            <div class="col-md-4">
                                <input id="date_of_birth" type="date" max="{{ date('Y-m-d') }}" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ isset($staff) ? $staff->date_of_birth : old('date_of_birth') }}" required autocomplete="date_of_birth" onchange="Javascript:myAgeValidation()">

                                @error('date_of_birth')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <label for="age" class="col-md-1 col-form-label text-md-end">{{ __('Age') }}</label>

                            <div class="col-md-2">
                                <input id="age" type="text" class="form-control" name="age" value="{{ isset($staff) ? $staff->age : old('age') }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="phone" class="col-md-3 col-form-label text-md-end">{{ __('Phone') }}</label>

                            <div class="col-md-7">
                                <input id="phone" type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ isset($staff) ? $staff->phone : old('phone') }}" required autocomplete="phone">

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="address" class="col-md-3 col-form-label text-md-end">{{ __('Address') }}</label>

                            <div class="col-md-7">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ isset($staff) ? $staff->address : old('address') }}" autocomplete="address">

                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="level_of_education" class="col-md-3 col-form-label text-md-end">{{ __('Level of Education') }}</label>

                            <div class="col-md-7">
                                <select id="level_of_education" class="form-control @error('level_of_education') is-invalid @enderror" name="level_of_education" required>
                                    <option value="" selected disabled>--Select--</option>
                                    <option @if (isset($staff) && $staff->level_of_education === "Primary") selected @endif value="Primary">Primary</option>
                                    <option @if (isset($staff) && $staff->level_of_education === "Secondary") selected @endif value="Secondary">Secondary</option>
                                    <option @if (isset($staff) && $staff->level_of_education === "Tertiary") selected @endif value="Tertiary">Tertiary</option>
                                </select>  

                                @error('level_of_education')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="qualification" class="col-md-3 col-form-label text-md-end">{{ __('Qualification') }}</label>

                            <div class="col-md-7">
                                <input id="qualification" type="text" class="form-control @error('qualification') is-invalid @enderror" name="qualification" value="{{ isset($staff) ? $staff->qualification : old('qualification') }}" autocomplete="qualification">

                                @error('qualification')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="position" class="col-md-3 col-form-label text-md-end">{{ __('Position') }}</label>

                            <div class="col-md-7">
                                <input id="position" type="text" class="form-control @error('position') is-invalid @enderror" name="position" value="{{ isset($staff) ? $staff->position : old('position') }}" autocomplete="position">

                                @error('position')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="banker" class="col-md-3 col-form-label text-md-end">{{ __('Banker') }}</label>

                            <div class="col-md-7">
                                <input id="banker" type="text" class="form-control @error('banker') is-invalid @enderror" name="banker" value="{{ isset($staff) ? $staff->banker : old('banker') }}" autocomplete="banker">

                                @error('banker')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="bank_account" class="col-md-3 col-form-label text-md-end">{{ __('Bank Account #') }}</label>

                            <div class="col-md-7">
                                <input id="bank_account" type="text" class="form-control @error('bank_account') is-invalid @enderror" name="bank_account" value="{{ isset($staff) ? $staff->bank_account : old('bank_account') }}" autocomplete="off">

                                @error('bank_account')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="bank_branch" class="col-md-3 col-form-label text-md-end">{{ __('Bank Branch') }}</label>

                            <div class="col-md-7">
                                <input id="bank_branch" type="text" class="form-control @error('bank_branch') is-invalid @enderror" name="bank_branch" value="{{ isset($staff) ? $staff->bank_branch : old('bank_branch') }}" autocomplete="bank_branch">

                                @error('bank_branch')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="ssnit_number" class="col-md-3 col-form-label text-md-end">{{ __('SSNIT #') }}</label>

                            <div class="col-md-7">
                                <input id="ssnit_number" type="text" class="form-control @error('ssnit_number') is-invalid @enderror" name="ssnit_number" value="{{ isset($staff) ? $staff->ssnit_number : old('ssnit_number') }}" autocomplete="off">

                                @error('ssnit_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="ghana_card" class="col-md-3 col-form-label text-md-end">{{ __('Ghana Card #') }}</label>

                            <div class="col-md-7">
                                <input id="ghana_card" type="text" class="form-control @error('ghana_card') is-invalid @enderror" name="ghana_card" value="{{ isset($staff) ? $staff->ghana_card : old('ghana_card') }}" autocomplete="off">

                                @error('ghana_card')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="insurance_number" class="col-md-3 col-form-label text-md-end">{{ __('Health Insurance #') }}</label>

                            <div class="col-md-7">
                                <input id="insurance_number" type="text" class="form-control @error('insurance_number') is-invalid @enderror" name="insurance_number" value="{{ isset($staff) ? $staff->insurance_number : old('insurance_number') }}" autocomplete="off">

                                @error('insurance_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="insurance_expiry" class="col-md-3 col-form-label text-md-end">{{ __('Insurance Expiry Date') }}</label>

                            <div class="col-md-4">
                                <input id="insurance_expiry" type="date" min="{{ date('Y-m-d') }}" class="form-control @error('insurance_expiry') is-invalid @enderror" name="insurance_expiry" value="{{ isset($staff) ? $staff->insurance_expiry : old('insurance_expiry') }}" required autocomplete="insurance_expiry" onchange="Javascript:insuranceExpiry()">

                                @error('insurance_expiry')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <label for="days" class="col-md-1 col-form-label text-md-end">{{ __('Days') }}</label>

                            <div class="col-md-2">
                                <input id="days" type="text" class="form-control" name="days" value="{{ isset($staff) ? $staff->expiry_days : old('days') }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="tin_number" class="col-md-3 col-form-label text-md-end">{{ __('TIN Number') }}</label>

                            <div class="col-md-7">
                                <input id="tin_number" type="text" class="form-control @error('tin_number') is-invalid @enderror" name="tin_number" value="{{ isset($staff) ? $staff->tin_number : old('tin_number') }}" autocomplete="tin_number">

                                @error('tin_number')
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

<script type="text/javascript">
    window.onload = function(){

        //Restrictions .................................................
        $('#name').on("input", function(){
            var regexp = /[^a-zA-Z -]/g;

            if ($(this).val().match(regexp)){
                $(this).val($(this).val().replace(regexp, ''));
            }
            });
            
        };

        //Age Calculator.............................................................
    
        function myAgeValidation() {
         
            var lre = /^\s*/;
            var datemsg = "";
            
            var inputDate = document.getElementById("date_of_birth").value;
            inputDate = inputDate.replace(lre, "");
            document.getElementById("date_of_birth").value = inputDate;
            getAge(new Date(inputDate));
         
        }
         
        function getAge(birth) {
         
            var today = new Date();
            var nowyear = today.getFullYear();
            var nowmonth = today.getMonth() + 1;
            var nowday = today.getDate();
         
            var birthyear = birth.getFullYear();
            var birthmonth = birth.getMonth() + 1;
            var birthday = birth.getDate();
         
            var age = nowyear - birthyear;
            var age_month = nowmonth - birthmonth;
            var age_day = nowday - birthday;


            if(age_month < 0 || (age_month == 0 && age_day < 0) ) {
                    age = parseInt(age) -1;
                    //age = age -1;
                }
            document.getElementById("age").value = age;
         
        }

        function insuranceExpiry() {
         
            var lre = /^\s*/;
            var datemsg = "";
            
            var inputDate = document.getElementById("insurance_expiry").value;
            inputDate = inputDate.replace(lre, "");
            document.getElementById("insurance_expiry").value = inputDate;
            getDays(new Date(inputDate));        
        }
   
     function getDays(birth) {
   
         var today = new Date();
     
         let difference = birth.getTime() - today.getTime(); 

         document.getElementById("days").value = Math.ceil(difference / (1000 * 3600 * 24));
      
     }
</script>
