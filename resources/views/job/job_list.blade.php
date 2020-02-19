@extends('layouts.base')

@section('content')
  <!-- Page Header Start -->
    <div class="page-header">
      <div class="container">
        <div class="row">         
          <div class="col-lg-12">
            <div class="inner-header">
              <h3>{{Request::is('joblist') ? 'My Projects' : 'Projects Taken'}} </h3>
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
                <div class="col-lg-3 col-md-3 col-xs-12">
                  <input type="text" class="form-control" placeholder="Keyword: Name, Tag" name="keyword">
                </div>
                <div class="col-lg-3 col-md-3 col-xs-12">
                  <input type="text" class="form-control" placeholder="Location: City, State, Zip" name="location">
                </div>
                <div class="col-lg-3 col-md-3 col-xs-12">
                  <select class="form-control" name="category_id" required>
                    <option value="">Select Category</option>
                    @foreach($category as $value)
                      <option value="{{$value->id}}">{{$value->category_name}}</option>
                    @endforeach                        
                  </select>
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
                  <div class="col-lg-3 col-md-3 col-xs-12">
                    <div class="job-company-logo">
                      <img src="assets/img/features/img1.png" alt="">
                    </div>
                    <div class="job-details">
                      <h3 class="text-capitalize">{{$value->job_title}}</h3>
                      <!-- <span class="company-neme">
                        {{@$value->company_name}}
                      </span> -->
                    </div>
                  </div>
                  <div class="col-lg-1 col-md-1 col-xs-12 text-center">
                    @if($value->category)
                      <span class="btn-open">
                        {{$value->category->category_name}}
                      </span>
                    @endif
                  </div>
                  <!-- <div class="col-lg-2 col-md-2 col-xs-12 text-right">
                   {{substr(html_entity_decode($value->description),0,10)}}
                  </div> -->

                  <div class="col-lg-2 col-md-2 col-xs-12 text-right">
                   {{$value->budget}}
                  </div>

                  <div class="col-lg-2 col-md-2 col-xs-12 text-right">
                    <?php $tags=explode(',', $value->job_tags); ?>
                    @foreach($tags as $value1)
                      <a href="" class="btn btn-default">{{$value1}}</a>
                    @endforeach
                  </div>

                  <div class="col-lg-1 col-md-1 col-xs-12 text-right">
                   {{date('F d, Y',strtotime($value->created_at))}}
                  </div>
                  
                  <div class="col-lg-3 col-md-3 col-xs-12 text-right">
                    @if(Auth::user())
                      @if(Auth::user()->user_type==1)
                        <a href="{{route('editPost',$value->id)}}" class="btn-apply">Edit</a>
                      @endif
                    @endif
                    <a href="{{route('viewPost',$value->id)}}" class="btn-apply">@if(Auth::user()) @if(Auth::user()->user_type==1 || Request::is('my_jobs') ) View @else Apply Now @endif @else Apply Now @endif</a>                    
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