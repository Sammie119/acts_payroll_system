@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1>{{ __('Payment List') }}</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row d-flex justify-content-center">
                <div class="col-md-12">
                    <div class="card card-primary">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-10">
                                <h5>{{ __('Payment List') }}</h5>
                            </div>
                            <div class="col-2">
                                <input class="form-control" type="text" id="search" style="height: 32px">
                            </div>
                            {{-- <div class="col-1">
                                <a href="{{ route('staff/create_staff') }}" class="btn btn-primary btn-sm">Add Staff</a>
                            </div> --}}
                        </div>  
                    </div>
                        <div class="card-body">
                            <form action="generate_payroll" method="post">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <select class="form-control" name="salary_month" required placeholder=" ">
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
                                            <label>Month</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <select class="form-control" name="salary_year" required placeholder=" " >
                                                <option value="" selected disabled>--Select Year--</option>
                                                <?php 
                                                   for($i = 2022 ; $i <= date('Y'); $i++){
                                                        $thisYear = (date('Y') == $i) ? 'selected' : null;
                                                      echo "<option ". $thisYear .">$i</option>";
                                                   }
                                                ?>
                                            </select>
                                            <label>Year</label>
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input type="text" name="description" class="form-control @error('email') is-invalid @enderror" required placeholder=" " >
                                            <label>Description</label>

                                            @error('description')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-success" style="margin-left: 89%; margin-right: -3;">Generate Payroll</button>
                                    </div>
                                </div>
                            </form>

                            <table class="table table-striped table-advdruge table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Full Name</th>
                                        <th>Position</th>
                                        <th>Gross Salary</th>
                                        <th>Net Salary</th>
                                        <th>Month</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="employee_table">
                                    @forelse ($salaries as $key => $salary)
                                        @php
                                            $salary_id = \App\Models\SetupSalary::select('salary_id')->where('staff_id', $salary->staff_id)->orderByDesc('salary_id')->first()->salary_id ?? 0;
                                        @endphp
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $salary->fullname }}</td>
                                            <td>{{ $salary->position }}</td>
                                            <td>{{ number_format($salary->pay_staff->last()->gross_income ?? 0, 2) }}</td>
                                            <td>{{ number_format($salary->pay_staff->last()->net_income ?? 0, 2)  }}</td>
                                            <td>{{ $salary->pay_staff->last()->pay_month ?? 'Month' }}, {{ $salary->pay_staff->last()->pay_year ?? '0000' }}</td>
                                            <td @if (isset($salary->pay_depend_on->last()->created_at) && date('d-m-Y') == $salary->pay_depend_on->last()->created_at->format('d-m-Y')) style="font-weight: bold;" @endif >{{ (isset($salary->pay_depend_on->last()->created_at)) ? $salary->pay_depend_on->last()->created_at->format('d-m-Y') : '00-00-0000' }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('view_paid_salaries', [$salary_id]) }}" class="btn btn-info btn-sm" title="View Details">View</a>
                                                    <a href="{{ route('salary_inputs', [$salary_id]) }}" class="btn btn-success btn-sm" title="Edit Details">Inputs</a>
                                                </div>
                                            </td>
                                        </tr> 
                                    @empty
                                        <tr>
                                            <td colspan="25">No Data Found</td>
                                        </tr> 
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

<script>
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
</script>


