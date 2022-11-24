@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1>{{ __('Staff List') }}</h1>
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
                                <h5>{{ __('Staff List') }}</h5>
                            </div>
                            <div class="col-2">
                                <input class="form-control" type="text" id="search" style="height: 32px">
                            </div>
                            <div class="col-1">
                                <a href="{{ route('staff/create_staff') }}" class="btn btn-primary btn-sm">Add Staff</a>
                            </div>
                        </div>  
                    </div>
                        <div class="card-body">
                            <table class="table table-striped table-advdruge table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Staff #.</th>
                                        <th>First Name</th>
                                        <th>Other Names</th>
                                        <th>Phone</th>
                                        <th>Age</th>
                                        <th>Education Level</th>
                                        <th>Position</th>
                                        <th>Insurance #</th>
                                        <th>Ins. Expiry</th>
                                        <th>User</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="employee_table">
                                    @forelse ($staff as $key => $staff)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $staff->staff_number }}</td>
                                            <td>{{ $staff->firstname }}</td>
                                            <td>{{ $staff->othernames }}</td>
                                            <td>{{ $staff->phone }}</td>
                                            <td>{{ $staff->age }}</td>
                                            <td>{{ $staff->level_of_education }}</td>
                                            <td>{{ $staff->position }}</td>
                                            <td>{{ $staff->insurance_number }}</td>
                                            <td>{{ $staff->insurance_number }}</td>
                                            <td>{{ $staff->user }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="staff/edit_staff/{{  $staff->staff_id }}" class="btn btn-success btn-sm" title="Edit">Edit</a>
                                                    <a class="btn btn-danger btn-sm" onclick="return confirm('The Selected record will be deleted permanently!!!')" href="staff/delete_staff/{{ $staff->staff_id }}" title="Delete">Del</a>
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


