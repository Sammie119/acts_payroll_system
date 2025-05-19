@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1>{{ "Notches for ". $grade }}</h1>
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
                                <h5>{{ __('Notches Levels') }}</h5>
                            </div>
                            <div class="col-2">
                                <input class="form-control" type="text" id="search" style="height: 32px">
                            </div>
{{--                            <div class="col-1">--}}
{{--                                <a href="" class="btn btn-primary btn-sm">Add Notch</a>--}}
{{--                            </div>--}}
                        </div>
                    </div>
                        <div class="card-body">
                            <table class="table table-striped table-advdruge table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Grade</th>
                                        <th>Notch Level</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="employee_table">
                                    @forelse ($notches as $key => $notch)
{{--                                        {{ dd($notches) }}--}}
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $grade }}</td>
                                            <td>{{ $notch->notch_level }}</td>
                                            <td>{{ $notch->description }}</td>
                                            <td>{{ number_format($notch->amount, 2) }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="/notches/edit/{{ $notch->id }}" class="btn btn-success btn-sm" title="Edit Details">Edit</a>
                                                </div>
                                                <div class="btn-group">
                                                    <a href="/notches/delete/{{ $notch->id }}" class="btn btn-danger btn-sm" title="Delete">Del</a>
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


