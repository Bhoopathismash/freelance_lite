@extends('layouts.base')

@section('content')
  <!-- Page Header Start -->
    <div class="page-header">
      <div class="container">
        <div class="row">         
          <div class="col-lg-12">
            <div class="inner-header">
              <h3>Profile</h3>
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
          <div class="col-lg-9 col-md-12 col-xs-12">
            <div class="post-job box">
              <h3 class="job-title">Post a new Job</h3>
              <form class="form-ad" method="POST" action="{{route('postJobStore')}}">
                @csrf
                <div class="form-group">
                  <label class="control-label">Job Title</label>
                  <input type="text" class="form-control" placeholder="Write job title" name="job_title" >
                </div>
                <div class="form-group">
                  <label class="control-label">Company</label>
                  <input type="text" class="form-control" placeholder="Write company name" name="company_name">
                </div>                 
                <div class="form-group">
                  <label class="control-label">Category</label>
                  <div class="search-category-container">
                    <label class="styled-select">
                      
                    </label>
                  </div>
                </div> 
                <div class="form-group">
                  <label class="control-label">Job Tags <span>(optional)</span></label>
                  <input type="text" class="form-control" placeholder="e.g.PHP,Social Media,Management" name="job_tags" >
                  <p class="note">Comma separate tags, such as required skills or technologies, for this job.</p>
                </div>  
                <div class="form-group">
                  <label class="control-label">Description</label> 
                  <textarea id="summernote" name="description"></textarea>                                 
                </div> 
                <!-- <section id="editor">
                  <div id="summernote"><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem quia aut modi fugit, ratione saepe perferendis odio optio repellat dolorum voluptas excepturi possimus similique veritatis nobis. Provident cupiditate delectus, optio?</p></div>
                </section> -->
                <div class="form-group">
                  <label class="control-label">Application email / URL</label>
                  <input type="text" class="form-control" placeholder="Enter an email address or website URL" name="email_url">
                </div>
                <div class="form-group">
                  <label class="control-label">Closing Date <span>(optional)</span></label>
                  <input type="text" class="form-control" placeholder="yyyy-mm-dd" name="closing_date">
                </div> 
                <div class="divider">
                  <h3 class="job-title">Company Details</h3>
                </div>
                <div class="form-group">
                  <label class="control-label">Company Name</label>
                  <input type="text" class="form-control" placeholder="Enter the name of the company" name="company_name">
                </div> 
                <div class="form-group">
                  <label class="control-label">Location <span>(optional)</span></label>
                  <input type="text" class="form-control" placeholder="e.g.London" name="location">
                </div> 
                <div class="form-group">
                  <label class="control-label">Website <span>(optional)</span></label>
                  <input type="text" class="form-control" placeholder="http://" name="website">
                </div> 
                <div class="form-group">
                  <label class="control-label">Tagline <span>(optional)</span></label>
                  <input type="text" class="form-control" placeholder="Briefly describe your company" name="tagline">
                </div>                 
                <div class="custom-file mb-3">
                  <input type="file" class="custom-file-input" id="validatedCustomFile" required name="job_file">
                  <label class="custom-file-label form-control" for="validatedCustomFile">Choose file...</label>
                  <div class="invalid-feedback">Example invalid custom file feedback</div>
                </div>
                <button type="Submit" class="btn btn-common">Submit your job</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Content section End -->   
@endsection

@section('scripts')
    
@endsection