@extends('layouts.base')

@section('content')
  <!-- Page Header Start -->
    <div class="page-header">
      <div class="container">
        <div class="row">         
          <div class="col-lg-12">
            <div class="inner-header">
              <h3>Post A Job</h3>
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
              <form class="form-ad" method="POST" action="{{route('postJobStore')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <label class="control-label">Job Title</label>
                  <input type="text" class="form-control" placeholder="Write job title" name="job_title" required>
                </div>                                
                <div class="form-group">
                  <label class="control-label">Category</label>
                  <div class="search-category-container">
                    <label class="styled-select">
                      <select class="dropdown-product selectpicker" name="category_id" required>
                        <option value="">Select Category</option>
                        @foreach($category as $value)
                          <option value="{{$value->id}}">{{$value->category_name}}</option>
                        @endforeach                        
                      </select>
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
                  <textarea id="summernote" name="job_description" required></textarea>                                 
                </div> 
                
                <div class="form-group">
                  <label class="control-label">Budget</label>
                  <input type="text" class="form-control" placeholder="Enter you budget" name="budget">
                </div>

                <div class="form-group">
                  <label class="control-label">Closing Date <span>(optional)</span></label>
                  <input type="text" class="form-control datepicker" placeholder="DD-MM-YYYY" name="closing_date" >
                </div>                

                <div class="form-group">
                  <label class="control-label">Attachments <span>(File can be in pdf,docx,doc,png,jpeg,jpeg)</span> </label>
                  <input type="file" class="form-control" id="validatedCustomFile" name="job_file[]" multiple="">
                </div>

                <div class="divider">
                  <h3 class="job-title">Milestone</h3>
                </div>
                <div class="custom-file mb-3">                  
                  <div class="mile-section">
                    <div class="mile-block" id="mile_block_0">
                      <div class="form-group">
                        <input type="text" name="milestone[]" placeholder="Milestone" class="form-control"  id="milestone_0" />
                      </div>
                      <div class="form-group">
                        <textarea name="description[]" id="description_0" class="form-control"  placeholder="Milestone Description"></textarea>
                      </div>
                    </div>
                  </div>
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