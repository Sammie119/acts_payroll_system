@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1>{{ __('Dropdown List') }}</h1>
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
                                <h5>{{ __('Dropdown List') }}</h5>
                            </div>
                            <div class="col-2">
                                <input class="form-control" type="text" id="search" style="height: 32px">
                            </div>
                            <div class="col-1">
                                <a href="{{ route('create_dropdown') }}" class="btn btn-primary btn-sm">Add New</a>
                            </div>
                        </div>
                    </div>
                        <div class="card-body">
                            <table class="table table-striped table-advdruge table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Dropdown Name</th>
                                        <th>Category</th>
                                        <th>Taxable</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="employee_table">
                                    @forelse ($dropdowns as $key => $dropdown)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $dropdown->dropdown_name }}</td>
                                            <td>{{ $dropdown->category_id === 1 ? 'Allowance' : ($dropdown->category_id === 2 ? 'Deduction' : 'Loan Description')}}</td>
                                            <td>{{ $dropdown->taxable === 1 ? 'Yes' : 'No' }}</td>
                                            <td>{{ $dropdown->created_at }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('edit_dropdown', [$dropdown->dropdown_id]) }}" class="btn btn-success btn-sm" title="Edit">Edit</a>
                                                    <a class="btn btn-danger btn-sm" onclick="return confirm('The Selected record will be deleted permanently!!!')" href="{{ route('delete_dropdown', [$dropdown->dropdown_id]) }}" title="Delete">Del</a>
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


