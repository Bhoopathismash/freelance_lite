@extends('layouts.base')

@section('content')
  <!-- Page Header Start -->
    <div class="page-header">
      <div class="container">
        <div class="row">         
          <div class="col-lg-12">
            <div class="inner-header">
              <h3>Edit A Job</h3>
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
              <h3 class="job-title">Edit Job</h3>
              <form class="form-ad" method="POST" action="{{route('postJobUpdate',$job->id)}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <label class="control-label">Job Title</label>
                  <input type="text" class="form-control" placeholder="Write job title" name="job_title" value="{{$job->job_title}}" required>
                </div>         

                <div class="form-group">
                  <label class="control-label">Category</label>
                  <div class="search-category-container">
                    <label class="styled-select">
                      <select class="dropdown-product selectpicker" name="category_id" required>
                        <option value="">Select Category</option>
                        @foreach($category as $value)
                          <option value="{{$value->id}}" @if($job->category_id==$value->id) selected  @endif>{{$value->category_name}}</option>
                        @endforeach
                      </select>
                    </label>
                  </div>
                </div> 
                <div class="form-group">
                  <label class="control-label">Job Tags <span>(optional)</span></label>
                  <input type="text" class="form-control" placeholder="e.g.PHP,Social Media,Management" name="job_tags" value="{{$job->job_tags}}" >
                  <p class="note">Comma separate tags, such as required skills or technologies, for this job.</p>
                </div>  
                <div class="form-group">
                  <label class="control-label">Description</label> 
                  <textarea id="summernote" name="job_description" required>{{$job->description}}</textarea>                                 
                </div> 
                <!-- <section id="editor">
                  <div id="summernote"><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem quia aut modi fugit, ratione saepe perferendis odio optio repellat dolorum voluptas excepturi possimus similique veritatis nobis. Provident cupiditate delectus, optio?</p></div>
                </section> -->
                <div class="form-group">
                  <label class="control-label">Email</label>
                  <input type="text" class="form-control" placeholder="Enter an email address" name="email" value="{{$job->email}}">
                </div>
                <div class="form-group">
                  <label class="control-label">Closing Date <span>(optional)</span></label>
                  <input type="text" class="form-control datepicker" placeholder="DD-MM-YYYY" name="closing_date" value="{{date('d-m-Y',strtotime($job->closing_date))}}" >
                </div> 
                <div class="divider">
                  <h3 class="job-title">Company Details</h3>
                </div>
                <div class="form-group">
                  <label class="control-label">Company Name</label>
                  <input type="text" class="form-control" placeholder="Enter the name of the company" name="company_name" value="{{$job->company_name}}">
                </div> 
                <div class="form-group">
                  <label class="control-label">Location <span>(optional)</span></label>
                  <input type="text" class="form-control" placeholder="e.g.London" name="location"  value="{{$job->company_name}}">
                </div> 
                <div class="form-group">
                  <label class="control-label">Website <span>(optional)</span></label>
                  <input type="text" class="form-control" placeholder="http://" name="website"  value="{{$job->location}}">
                </div> 
                <div class="form-group">
                  <label class="control-label">Tagline <span>(optional)</span></label>
                  <textarea class="form-control" placeholder="Briefly describe your company" name="tagline">{{$job->tagline}}</textarea>
                </div>     

                <div class="form-group">
                  <label class="control-label">Job Details <span>(File can be in pdf,docx,doc,png,jpeg,jpeg)</span> </label>
                  <input type="file" class="form-control" id="validatedCustomFile" name="job_file">
                  @if($job->job_file)
                      <img src="{{$job->job_file}}" class="img-responsive"  />
                  @endif
                </div>

                <div class="divider">
                  <h3 class="job-title">Milestone</h3>
                </div>
                <div class="custom-file mb-3">  
                  @foreach($job->milestone as $index => $value)
                    <div class="mile-section">
                      <div class="mile-block" id="mile_block_{{$index}}">
                        <div class="form-group">
                          <input type="text" name="milestone[]" placeholder="Milestone" class="form-control"  id="milestone_{{$index}}" value="{{$value->milestone}}" />
                        </div>
                        <div class="form-group">
                          <textarea name="description[]" id="description_{{$index}}" class="form-control"  placeholder="Milestone Description">{{$value->description}}</textarea>
                        </div>
                        <div class="form-group"> <button type="button" id="remove_mile_{{$index}}" class="btn btn-danger remove_mile" style="float:right;" onclick="removemile({{$index}})" alt="Remove Milestone">X</button></div><br>
                      </div>
                    </div>
                  @endforeach
                  <br>
                  <button type="button" id="add_mile" class="btn btn-info">+ Add Milestone</button>
                </div>

                <div class="form-group">
                  <br>
                  <br>
                  <button type="Submit" class="btn btn-common">Submit your job</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Content section End -->   
@endsection

@section('scripts')

<script type="text/javascript">
  
    $(document).ready(function() {

      var n=1;
      
      $('#add_mile').click(function(){

          var mile_html='<div class="mile-block" id="mile_block_'+n+'"><hr><div class="form-group"><input type="text" name="milestone[]" id="milestone_'+n+'" class="form-control" placeholder="Milestone"/></div><div class="form-group"><textarea name="description[]" id="description_'+n+'" class="form-control" placeholder="Milestone Description"></textarea></div><div class="form-group"> <button type="button" id="remove_mile_'+n+'" class="btn btn-danger remove_mile" style="float:right;" onclick="removemile('+n+')" alt="Remove Milestone">X</button></div><br></div>';

          $('.mile-section').append(mile_html);
          n+=1;

      });    

    });

    function removemile(n){
        $('#mile_block_'+n).remove();
    }
</script>

@endsection