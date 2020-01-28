@extends('admin.layout.base')

@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Category Edit</h1>
    
    <br>
    
    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-table mr-1"></i>Edit</div>
        <div class="card-body">
            <form method="POST" action="{{route('admin.category.update',$category->id)}}"> 
            @csrf           
            @method('PATCH')
            <div class="col-xl-3 col-md-6">
                <div class="form-group">
                    <label>Category Name</label>
                    <input type="text" name="category_name" class="form-control" required  value="{{$category->category_name}}" />
                </div>

                <div class="form-group">
                    <label>Category Name</label>
                    <select name="status" class="form-control" required >
                        <option value="1" @if($category->status==1) selected @endif> Active </option> 
                        <option value="0" @if($category->status==0) selected @endif> Inactive </option> 
                    </select>
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