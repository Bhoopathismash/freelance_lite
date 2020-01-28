@extends('layouts.base')

@section('content')
  <!-- Page Header Start -->
    <div class="page-header">
      <div class="container">
        <div class="row">         
          <div class="col-lg-12">
            <div class="inner-header">
              <h3>Jobs</h3>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page Header End -->  

    <!-- Content section Start --> 
    <section class="section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-12 col-md-12 col-xs-12">
            <div class="post-job box">
              <h3 class="job-title">Job List</h3>
              
              <div class="table-responsive">
                <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Job Title</th>
                            <th>Company Name</th>                            
                            <th>Category</th>                            
                            <th>Status</th>                            
                            <th>Action</th>                            
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>S.No</th>
                            <th>Job Title</th>
                            <th>Company Name</th>                            
                            <th>Category</th>                            
                            <th>Status</th>                            
                            <th>Action</th>                         
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($jobs as $index => $value)
                        <tr>
                            <td>{{$index +1}}</td>
                            <td>{{$value->job_title}}</td>
                            <td>{{$value->company_name}}</td>
                            <td>{{$value->category->category_name}}</td>
                            <td>@if($value->status==0) Not Started @elseif($value->status==0) Biding @elseif($value->status==0)Started @elseif($value->status==0) Finished @endif</td>
                            <td>
                              @if(Auth::user()->user_type==1)
                                <a href="{{route('editPost',$value->id)}}" class="btn btn-info">Edit</a>
                              @endif
                              <a href="{{route('viewPost',$value->id)}}" class="btn btn-info">View</a>
                            </td>                    
                        </tr>  
                        @endforeach                      
                    </tbody>
                </table>
            </div>

            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Content section End -->   
@endsection

@section('scripts')
    
@endsection