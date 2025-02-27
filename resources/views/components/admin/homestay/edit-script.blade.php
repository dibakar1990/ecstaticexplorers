<script>
    $(document).ready(function() {
       function readURL(input) {
           if (input.files && input.files[0]) {
               var filesAmount = input.files.length;
               let i;
               for (i = 0; i < filesAmount; i++) {
                   var reader = new FileReader();

                   reader.onload = function(e) {
                       var html = '<div class="col-md-2"><img src="' + e.target.result + '" class="rounded float-start no-image-preview"></div>';
                       $('.preview-images-zone').append(html);
                   }

                   reader.readAsDataURL(input.files[i]);
               }
           }
       }

       // Trigger image preview when file input changes
       $("input[name='file[]']").change(function() {
           readURL(this);
       });
   });

   $(function() {
       var state_id;
       "use strict";
       $('.single-select').select2({
           theme: 'bootstrap4',
           width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
           placeholder: $( this ).data( 'placeholder' ),
           allowClear: Boolean($(this).data('allow-clear')),
       });


       $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
       });
       $("#state_id").change(function(){
          
           var state_id = $(this).val();
           var actionUrl = $(document).find('.fetchCityActionUrl').val();
          
           $.ajax({
               url: actionUrl,
               method: 'POST',
               data: {id:state_id},
               success: function(data) {
                   $("select[name='location_id'").html('');
                   $("select[name='location_id'").html(data.response.response);
               }
           });
       
       });

       $('.summernote').summernote({
           height: 250,
           
       });


       // Itinerary
       var wrapperItinerary        = $("#input_fields_wrap_itinerary"); //Fields wrapper
        var add_button_itinerary     = $(".add_field_button_itinerary"); //Add button ID
       
        var w = 1;
        $(add_button_itinerary).click(function(e){ //on add input button click
           
            e.preventDefault();
            var html = '<div class="input-field-wrap-itinerary" id="input_fields_wrap_itinerary_'+w+'"><div class="row"><div class="col-md-4 required"><label for="title_text_'+w+'" class="form-label">Title</label><input type="text" class="form-control" id="title_text_'+w+'" name="facilities['+w+'][title_text]" placeholder="Text" required></div><div class="col-md-4 required"><label for="bed_'+w+'" class="form-label">Bed</label><input type="text" class="form-control" id="bed_'+w+'" name="facilities['+w+'][bed]" placeholder="Bed" required></div><div class="col-md-4 required"><label for="occupancy_'+w+'" class="form-label">Occupancy</label><input type="number" class="form-control" id="occupancy_'+w+'" name="facilities['+w+'][occupancy]" placeholder="Occupancy" required></div><div class="col-md-4 required"><label for="toilet_with_geyser_'+w+'" class="form-label"> Attached western toilet with Geyser</label><select class="form-select single-select" id="toilet_with_geyser_'+w+'" name="facilities['+w+'][toilet_with_geyser]" required><option value="1">Yes</option><option value="0">No</option></select></div><div class="col-md-4 required"><label for="view_'+w+'" class="form-label">View</label><input type="text" class="form-control" id="view_'+w+'" name="facilities['+w+'][view]" placeholder="Bed" required></div><div class="col-md-4 required"><label for="toilet_'+w+'" class="form-label">Attached Toilet</label><select class="form-select single-select" id="toilet_'+w+'" name="facilities['+w+'][toilet]" required><option value="1">Yes</option><option value="0">No</option></select></div><div class="col-md-10 required"><label for="file_img_'+w+'" class="form-label">Image</label><input type="file" class="form-control" name="facilities['+w+'][facility_file]" id="file_img_'+w+'" accept="image/*" required></div><div class="col-md-2"><a class="ms-1 btn btn-sm btn-outline-danger px-1 remove_field_itinerary" data-no-itinerary="'+w+'"><i class="bx bxs-trash"></i></a></div></div></div>'
            $(wrapperItinerary).append(html);
            $('#toilet_'+w).select2({
                theme: 'bootstrap4',
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
                allowClear: Boolean($(this).data('allow-clear')),
            });
            $('#toilet_with_geyser_'+w).select2({
                theme: 'bootstrap4',
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
                allowClear: Boolean($(this).data('allow-clear')),
            });
            w++;
        });
        $(wrapperItinerary).on("click",".remove_field_itinerary", function(d){ //user click on remove text
            d.preventDefault(); 
            var num = $(this).attr('data-no-itinerary');
            $('#input_fields_wrap_itinerary_'+num).remove();
        });

       $('form#editForm').on('submit', function(event) {
           $('#title').each(function() {
               $(this).rules("add", 
               {
                   required: true,
                   messages: {
                       required: "This field is required",
                   }
               });
           });
          
           $('#state_id').each(function() {
               $(this).rules("add", 
               {
                   required: true,
                   messages: {
                       required: "This field is required",
                   }
               });
           });
           $('#location_id').each(function() {
               $(this).rules("add", 
               {
                   required: true,
                   messages: {
                       required: "This field is required",
                   }
               });
           });
           $('#property_classification').each(function() {
               $(this).rules("add", 
               {
                   required: true,
                   messages: {
                       required: "This field is required",
                   }
               });
           });
           $('#property_uniqueness').each(function() {
               $(this).rules("add", 
               {
                   required: true,
                   messages: {
                       required: "This field is required",
                   }
               });
           });
           
           $('#traiff').each(function() {
               $(this).rules("add", 
               {
                   required: true,
                   messages: {
                       required: "This field is required",
                   }
               });
           });
           $('#price').each(function() {
               $(this).rules("add", 
               {
                   required: true,
                   messages: {
                       required: "This field is required",
                   }
               });
           });
           $('.summernote').each(function() {
               $(this).rules("add", 
               {
                   required: true,
                   messages: {
                       required: "This field is required",
                   }
               });
           });
   
       });

       $("#editForm").validate({
           ignore: [],
           debug: false,
           errorElement: 'span',
           errorPlacement: function (error, element) {
               error.addClass('invalid-feedback');
               element.closest('.required').append(error);
           },
           highlight: function (element, errorClass, validClass) {
               $(element).addClass('is-invalid');
           },
           unhighlight: function (element, errorClass, validClass) {
               $(element).removeClass('is-invalid');
           }
       });
   });
</script>