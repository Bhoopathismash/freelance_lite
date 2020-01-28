@extends('admin.layout.base')

@section('content')
<div class="container-fluid">
    <div class="">
        <h1 class="mt-4">Category</h1>
        <a href="{{route('admin.category.create')}}" class="btn btn-success">+ Add Category</a>
    </div>
        <br>
    
    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-table mr-1"></i>Category List</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Category</th>
                            <th>Status</th>                            
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>S.No</th>
                            <th>Category</th>
                            <th>Status</th>                            
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($category as $index => $value)
                        <tr>
                            <td>{{$index +1}}</td>
                            <td>{{$value->category_name}}</td>
                            <td>@if($value->status==0) Inactive @else Active @endif</td>
                            <td><a href="{{route('admin.category.edit',$value->id)}}" class="btn btn-info">Edit</a></td>                            
                        </tr>  
                        @endforeach                      
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>         
@endsection      