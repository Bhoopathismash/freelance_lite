@extends('admin.layout.base')

@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Jobs</h1>
        
    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-table mr-1"></i>Job List</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Job Title</th>
                            <th>Company Name</th>                            
                            <th>Location</th>                            
                            <th>Category</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>S.No</th>
                            <th>Job Title</th>
                            <th>Company Name</th>                            
                            <th>Location</th>                            
                            <th>Category</th>
                    </tfoot>
                    <tbody>
                        @foreach($jobs as $index => $value)
                        <tr>
                            <td>{{$index +1}}</td>
                            <td>{{$value->job_title}}</td>
                            <td>{{$value->company_name}}</td>
                            <td>{{$value->location}}</td>
                            <td>{{$value->category->category_name}}</td>                                                  
                        </tr>  
                        @endforeach                      
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>         
@endsection      