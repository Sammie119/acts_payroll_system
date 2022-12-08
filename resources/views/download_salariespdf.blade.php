@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1>{{ __('Generated Payslips') }}</h1>
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
                                <h5>{{ __('Generated Payslips') }}</h5>
                            </div>
                        </div>  
                    </div>
                        <div class="card-body">
                            <table class="table table-striped table-advdruge table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Description</th>
                                        <th>File</th>
                                        <th>Month</th>
                                        <th>Year</th>
                                        <th>Date</th>
                                        <th>Email Status</th>
                                        <th>User</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="employee_table">
                                    @forelse ($slips as $key => $slip)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $slip->description }}</td>
                                            <td>{{ $slip->file_name }}</td>
                                            <td>{{ $slip->month }}</td>
                                            <td>{{ $slip->year }}</td>
                                            <td>{{ $slip->created_at->format('d-m-Y') }}</td>
                                            <td>{{ ($slip->email_status === 0) ? 'Not Sent' : 'Sent' }}</td>
                                            <td>{{ getFirstname($slip->username->name) }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a class="btn btn-primary btn-sm" href="{{ route('download_pdf', [$slip->file_name]) }}" title="Download">Download</a>
                                                    <a class="btn btn-danger btn-sm" onclick="return confirm('The Generated Salaries will be deleted permanently!!!')" href="{{ route('delete_payslips',[$slip->month, $slip->year, $slip->file_name]) }}" title="Delete">Del</a>
                                                    <a class="btn btn-success btn-sm" onclick="return confirm('Emails will be sent to Staff with email address!!!')" href="{{ route('send_emal', [$slip->month, $slip->year]) }}" title="Download">Email</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10">No Salaries Generated</td>
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


