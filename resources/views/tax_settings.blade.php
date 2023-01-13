@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-sm-9">
                    <h1>{{ __('PAYE Tax') }}</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('PAYE Tax') }}</h5>
                        </div>
        
                        <div class="card-body">
                            <form method="POST" action="store_taxs">  
                            
                                @csrf
                                       
                                <div class="row mb-3" style="font-weight: bold">
                                    <label class="col-md-3 col-form-label text-md-end">{{ __('Level') }}</label>
    
                                    <label class="col-md-3 col-form-label text-md-end">{{ __('Chargeable Income') }}</label>
    
                                    <label class="col-md-2 col-form-label text-md-end">{{ __('Tax Rate (%)') }}</label>

                                    <label class="col-md-3 col-form-label text-md-end">{{ __('Tax Payable') }}</label>
                                </div>
    
                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label text-md-end">{{ __('First') }}</label>
    
                                    <div class="col-md-3">
                                        <input type="number" step="0.01" min="1" class="form-control @error('first_0') is-invalid @enderror" name="first_0" value="{{ $tax->first_0 }}" required>
                                        
                                        @error('first_0')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-2">
                                        <input type="number" step="0.01" min="0" class="form-control @error('rate_0') is-invalid @enderror" name="rate_0" value="{{ $tax->rate_0 }}" required>
                                        
                                        @error('rate_0')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <input type="text" class="form-control" value="{{ number_format($tax->first_0 * ($tax->rate_0/100), 2) }}" readonly>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label text-md-end">{{ __('Next') }}</label>
    
                                    <div class="col-md-3">
                                        <input type="number" step="0.01" min="1" class="form-control @error('next_5') is-invalid @enderror" name="next_5" value="{{ $tax->next_5 }}" required>
                                        
                                        @error('next_5')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-2">
                                        <input type="number" step="0.01" min="0" class="form-control @error('rate_1') is-invalid @enderror" name="rate_1" value="{{ $tax->rate_1 }}" required>
                                        
                                        @error('rate_1')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" value="{{ number_format($tax->next_5 * ($tax->rate_1/100), 2) }}" readonly>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label text-md-end">{{ __('Next') }}</label>
    
                                    <div class="col-md-3">
                                        <input type="number" step="0.01" min="1" class="form-control @error('next_10') is-invalid @enderror" name="next_10" value="{{ $tax->next_10 }}" required>
                                        
                                        @error('next_10')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-2">
                                        <input type="number" step="0.01" min="0" class="form-control @error('rate_2') is-invalid @enderror" name="rate_2" value="{{ $tax->rate_2 }}" required>
                                        
                                        @error('rate_2')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" value="{{ number_format($tax->next_10 * ($tax->rate_2/100), 2) }}" readonly>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label text-md-end">{{ __('Next') }}</label>
    
                                    <div class="col-md-3">
                                        <input type="number" step="0.01" min="1" class="form-control @error('next_17_5') is-invalid @enderror" name="next_17_5" value="{{ $tax->next_17_5 }}" required>
                                        
                                        @error('next_17_5')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-2">
                                        <input type="number" step="0.01" min="0" class="form-control @error('rate_3') is-invalid @enderror" name="rate_3" value="{{ $tax->rate_3 }}" required>
                                        
                                        @error('rate_3')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" value="{{ number_format($tax->next_17_5 * ($tax->rate_3/100), 2) }}" readonly>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label text-md-end">{{ __('Next') }}</label>
    
                                    <div class="col-md-3">
                                        <input type="number" step="0.01" min="1" class="form-control @error('next_25') is-invalid @enderror" name="next_25" value="{{ $tax->next_25 }}" required>
                                        
                                        @error('next_25')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-2">
                                        <input type="number" step="0.01" min="0" class="form-control @error('rate_4') is-invalid @enderror" name="rate_4" value="{{ $tax->rate_4 }}" required>
                                        
                                        @error('rate_4')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" value="{{ number_format($tax->next_25 * ($tax->rate_4/100), 2) }}" readonly>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label text-md-end">{{ __('Next') }}</label>
    
                                    <div class="col-md-3">
                                        <input type="number" step="0.01" min="1" class="form-control @error('exceeding') is-invalid @enderror" name="exceeding" value="{{ $tax->exceeding }}" required>
                                        
                                        @error('exceeding')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-2">
                                        <input type="number" step="0.01" min="0" class="form-control @error('rate_5') is-invalid @enderror" name="rate_5" value="{{ $tax->rate_5 }}" required>
                                        
                                        @error('rate_5')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" value="{{ number_format($tax->exceeding * ($tax->rate_5/100), 2) }}" readonly>
                                    </div>
                                </div>

                                <hr>

                                <div class="row mb-3" style="font-weight: bold">
                                    <label class="col-md-3 col-form-label text-md-end">{{ __('SSNIT') }}</label>
    
                                    <label class="col-md-3 col-form-label text-md-end">{{ __('%') }}</label>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label text-md-end">{{ __('SSF Employer') }}</label>
    
                                    <div class="col-md-3">
                                        <input type="number" step="0.01" min="1" class="form-control @error('ssf_employer') is-invalid @enderror" name="ssf_employer" value="{{ $tax->ssf_employer }}" required>
                                        
                                        @error('ssf_employer')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label text-md-end">{{ __('SSF Employee') }}</label>
    
                                    <div class="col-md-3">
                                        <input type="number" step="0.01" min="1" class="form-control @error('ssf_employee') is-invalid @enderror" name="ssf_employee" value="{{ $tax->ssf_employee }}" required>
                                        
                                        @error('ssf_employee')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="row mb-0">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Submit') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

{{-- <script>
    window.onload = function(){
        $('#search').focus();

        // Table filter
        $('#search').keyup(function(){  
            search_table($(this).val());  
        });  
        function search_table(value){  
            $('#employee_table tr').each(function(){  
                var found = 'false';  
                $(this).each(function(){  
                    if($(this).text().toLowerCase().indexOf(value.toLowerCase()) >= 0){  
                        found = 'true';  
                    }  
                });  
                if(found == 'true'){  
                    $(this).show();  
                }  
                else{  
                    $(this).hide();  
                }  
            });  
        }

    };
</script> --}}


