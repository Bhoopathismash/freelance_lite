@extends('admin.layout.base')

@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Category Create</h1>
    
    <br>
    
    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-table mr-1"></i>Create</div>
        <div class="card-body">
            <form method="POST" action="{{route('admin.category.store')}}"> 
            @csrf           
            <div class="col-xl-3 col-md-6">
                <div class="form-group">
                    <label>Category Name</label>
                    <input type="text" name="category_name" class="form-control" required />
                </div>
                <div class="form-group">                    
                    <button type="submit" class="btn btn-primary"> Save </button>
                    <a href="{{route('admin.category.index')}}" class="btn btn-danger">< Back </a>
                </div>
            </div> 
            </form>
        
        </div>
    </div>
    
   
</div>         
@endsection      