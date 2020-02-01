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
    <section class="job-browse section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-12 col-md-12 col-xs-12">
            <form action="{{route('jobList')}}" method="GET">
            <div class="wrap-search-filter row">
                <div class="col-lg-5 col-md-5 col-xs-12">
                  <input type="text" class="form-control" placeholder="Keyword: Name, Tag" name="keyword">
                </div>
                <div class="col-lg-5 col-md-5 col-xs-12">
                  <input type="text" class="form-control" placeholder="Location: City, State, Zip" name="location">
                </div>
                <div class="col-lg-2 col-md-2 col-xs-12">
                  <button type="submit" class="btn btn-common float-right">Filter</button>
                </div>
            </div>
            </form>
          </div>
           <div class="col-lg-12 col-md-12 col-xs-12">
            @foreach($jobs as $index => $value)
              <div class="job-listings">
                <div class="row">
                  <div class="col-lg-4 col-md-4 col-xs-12">
                    <div class="job-company-logo">
                      <img src="assets/img/features/img1.png" alt="">
                    </div>
                    <div class="job-details">
                      <h3>{{$value->job_title}}</h3>
                      <span class="company-neme">
                        {{@$value->company_name}}
                      </span>
                    </div>
                  </div>
                  <div class="col-lg-2 col-md-2 col-xs-12 text-center">
                    @if($value->category)
                      <span class="btn-open">
                        {{$value->category->category_name}}
                      </span>
                    @endif
                  </div>
                  <div class="col-lg-2 col-md-2 col-xs-12 text-right">
                   <div class="location">
                     <i class="lni-map-marker"></i> {{@$value->location}}
                   </div>
                  </div>
                  
                  <div class="col-lg-4 col-md-4 col-xs-12 text-right">
                    @if(Auth::user()->user_type==1)
                      <a href="{{route('editPost',$value->id)}}" class="btn btn-info">Edit</a>
                    @endif
                    <a href="{{route('viewPost',$value->id)}}" class="btn-apply">@if(Auth::user()->user_type==1) View @else Apply Now @endif</a>                    
                  </div>
                </div>
              </div>
            @endforeach        

            <!-- Start Pagination -->
            {!! $jobs->links() !!}            
            <!-- End Pagination -->
          </div>
        </div>
      </div>
    </section>
    <!-- Content section End -->   
@endsection

@section('scripts')
    
@endsection