@extends('admin.layout.base')

@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Users</h1>        
    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-table mr-1"></i>Users List</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Name</th>
                            <th>User Type</th>                            
                            <th>Email</th>                            
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>S.No</th>
                            <th>Name</th>
                            <th>User Type</th>                            
                            <th>Email</th>                            
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($users as $index => $value)
                        <tr>
                            <td>{{$index +1}}</td>
                            <td>{{$value->name}}</td>
                            <td>@if($value->user_type==1) Hire @else Work @endif</td>
                            <td>{{$value->email}}</td>                            
                        </tr>  
                        @endforeach                      
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>         
@endsection      