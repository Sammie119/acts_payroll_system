@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1>{{ __('Setup Salaries') }}</h1>
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
                            <div class="col-9">
                                <h5>{{ __('Setup Salaries') }}</h5>
                            </div>
                            <div class="col-2">
                                <input class="form-control" type="text" id="search" style="height: 32px">
                            </div>
                            <div class="col-1">
                                <a href="{{ route('salary/create_salary') }}" class="btn btn-primary btn-sm">Add Salary</a>
                            </div>
                        </div>  
                    </div>
                        <div class="card-body">
                            <table class="table table-striped table-advdruge table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Staff #</th>
                                        <th>Full Name</th>
                                        <th>Qualification</th>
                                        <th>Position</th>
                                        <th>Basic Salary</th>
                                        <th>Tax Relief</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="employee_table">
                                    @forelse ($salary as $key => $salary)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $salary->staff->staff_number }}</td>
                                            <td>{{ $salary->staff->fullname }}</td>
                                            <td>{{ $salary->staff->qualification }}</td>
                                            <td>{{ $salary->staff->position }}</td>
                                            <td>{{ number_format($salary->salary, 2) }}</td>
                                            <td>{{ number_format($salary->tax_relief, 2) }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="salary/edit_salary/{{ $salary->salary_id }}" class="btn btn-success btn-sm" title="Edit Details">Edit</a>
                                                </div>
                                            </td>
                                        </tr> 
                                    @empty
                                        <tr>
                                            <td colspan="40">No data Found</td>
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


