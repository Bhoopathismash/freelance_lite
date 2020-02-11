    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="{{ asset('assets/js/jquery-min.js')}}"></script>
    <script src="{{ asset('assets/js/popper.min.js')}}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js')}}"></script>     
    <script src="{{ asset('assets/js/jquery.slicknav.js')}}"></script>     
    <script src="{{ asset('assets/js/jquery.counterup.min.js')}}"></script>      
    <script src="{{ asset('assets/js/waypoints.min.js')}}"></script>     
    <script src="{{ asset('assets/js/form-validator.min.js')}}"></script>
    <script src="{{ asset('assets/js/contact-form-script.js')}}"></script>   
    <script src="{{ asset('assets/js/main.js')}}"></script>
    <script src="{{ asset('assets/js/app.js')}}"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="{{ asset('assets/js/summernote.js')}}"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>

    
    <script>
        $(document).ready(function() {

            $('.dataTable').DataTable();
            
            $('.datepicker').datepicker({
                    format: 'dd-mm-yyyy',
                    startDate:new Date()
                });

            $('#summernote').summernote();
            $('#summernot1e').summernote({
                height: 250,                 // set editor height
                minHeight: null,             // set minimum height of editor
                maxHeight: null,             // set maximum height of editor
                focus: false                 // set focus to editable area after initializing summernote
            });
        });
      
    </script>


    @yield('scripts')