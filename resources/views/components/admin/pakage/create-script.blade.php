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

        $( '.multiple-select-field' ).select2( {
            theme: "bootstrap4",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: 'Choose tag',
            closeOnSelect: false,
        } );

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
                    $("select[name='cities[0][city_id]'").html('');
                    $("select[name='cities[0][city_id]'").html(data.response.response);
                }
            });
        
        });

        $('.summernote').summernote({
            height: 250,
        });

        //pakage feature
        var wrapper         = $("#input_fields_wrap"); //Fields wrapper
        var add_button      = $(".add_field_button"); //Add button ID
        var i = 1;
        $(add_button).click(function(e){ //on add input button click
            e.preventDefault();
            var html = '<div class="input-field-wrap" id="input_fields_wrap_'+i+'"><div class="row"><div class="col-md-10 required"><input type="text" class="form-control pakage-feature" id="pakage_feature_'+i+'" name="pakage_feature[]" placeholder="Pakage Fature value" required></div><div class="col-md-2"><a class="ms-1 btn btn-sm btn-outline-danger px-1 remove_field" data-no="'+i+'"><i class="bx bxs-trash"></i></a></div></div></div>';
            $(wrapper).append(html);
            i++;
        });
        $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); 
            var num = $(this).attr('data-no');
            $('#input_fields_wrap_'+num).remove();
        });

        // Pakage Do
        var wrapperDo        = $("#input_fields_wrap_do"); //Fields wrapper
        var add_button_do      = $(".add_field_button_do"); //Add button ID
       
        var k = 1;
        $(add_button_do).click(function(d){ //on add input button click
           
            d.preventDefault();
            var html = '<div class="input-field-wrap-do" id="input_fields_wrap_do_'+k+'"><div class="row"><div class="col-md-10 required"><input type="text" class="form-control pakage-do" id="pakage_do_'+k+'" name="pakage_do[]" placeholder="Pakage do value" required></div><div class="col-md-2"><a class="ms-1 btn btn-sm btn-outline-danger px-1 remove_field_do" data-no-do="'+k+'"><i class="bx bxs-trash"></i></a></div></div></div>';
            $(wrapperDo).append(html);
            k++;
        });
        $(wrapperDo).on("click",".remove_field_do", function(d){ //user click on remove text
            d.preventDefault(); 
            var num = $(this).attr('data-no-do');
            $('#input_fields_wrap_do_'+num).remove();
        });


        // Pakage Dont
        var wrapperDont        = $("#input_fields_wrap_dont"); //Fields wrapper
        var add_button_dont      = $(".add_field_button_dont"); //Add button ID
       
        var j = 1;
        $(add_button_dont).click(function(e){ //on add input button click
           
            e.preventDefault();
            var html = '<div class="input-field-wrap-dont" id="input_fields_wrap_dont_'+j+'"><div class="row"><div class="col-md-10 required"><input type="text" class="form-control pakage-do" id="pakage_do_'+j+'" name="pakage_dont[]" placeholder="Pakage dont value" required></div><div class="col-md-2"><a class="ms-1 btn btn-sm btn-outline-danger px-1 remove_field_dont" data-no-dont="'+j+'"><i class="bx bxs-trash"></i></a></div></div></div>';
            $(wrapperDont).append(html);
            j++;
        });
        $(wrapperDont).on("click",".remove_field_dont", function(d){ //user click on remove text
            d.preventDefault(); 
            var num = $(this).attr('data-no-dont');
            $('#input_fields_wrap_dont_'+num).remove();
        });

        // Itinerary
        var wrapperItinerary        = $("#input_fields_wrap_itinerary"); //Fields wrapper
        var add_button_itinerary     = $(".add_field_button_itinerary"); //Add button ID
       
        var w = 1;
        $(add_button_itinerary).click(function(e){ //on add input button click
           
            e.preventDefault();
            var html = '<div class="input-field-wrap-itinerary" id="input_fields_wrap_itinerary_'+w+'"><div class="row"><div class="col-md-2"><input type="number" class="form-control" id="day_no_'+w+'" name="tour_itineraries['+w+'][day_no]" placeholder="Day no"></div><div class="col-md-2"><select class="form-select single-select" id="check_in_'+w+'" name="tour_itineraries['+w+'][check_in]"><option value="1">Yes</option><option value="0">No</option></select></div><div class="col-md-2"><select class="form-select single-select" id="sight_seeing_'+w+'" name="tour_itineraries['+w+'][sight_seeing]"><option value="1">Yes</option><option value="0">No</option></select></div><div class="col-md-6"><input type="text" class="form-control" id="title_'+w+'" name="tour_itineraries['+w+'][title]" placeholder="Title"></div><div class="col-md-6"><input type="text" class="form-control" id="title_text_'+w+'" name="tour_itineraries['+w+'][title_text]" placeholder="Text"></div><div class="col-md-4 required"><input type="text" class="form-control" id="stay_at_'+w+'" name="tour_itineraries['+w+'][stay_at]" placeholder="Stay at"></div><div class="col-md-2"><a class="ms-1 btn btn-sm btn-outline-danger px-1 remove_field_itinerary" data-no-itinerary="'+w+'"><i class="bx bxs-trash"></i></a></div></div></div>'
            $(wrapperItinerary).append(html);
            $('#check_in_'+w).select2({
                theme: 'bootstrap4',
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
                allowClear: Boolean($(this).data('allow-clear')),
            });
            $('#sight_seeing_'+w).select2({
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

        // Itinerary Hotel Image
        var hotel_wrapper         = $("#input_hotel_fields_wrap"); //Fields wrapper
        var add_city_button_hotel      = $(".add_city_field_button-hotel"); //Add button ID
        var h = 1;
        $(add_city_button_hotel).click(function(e){ //on add input button click
            e.preventDefault();
            var html = '';
            html +='';
            html +='<div class="input-field-wrap-hotel" id="input_hotel_fields_wrap_'+h+'"><div class="row"><div class="col-md-3 required"><select class="form-select type-id" id="type_id_'+c+'" data-placeholder="Choose type" name="hotels['+h+'][type_id]" required><option value="">Choose type</option>';
                <?php foreach ($types as $tkey => $type):?>
                   html +='<option value="{{ $type->id }}">{{ $type->name }}</option>';
               <?php endforeach ?>
               
            html +='</select></div><div class="col-md-3 required"><input type="file" class="form-control" name="hotels['+h+'][hotel_file]" id="img_'+h+'" accept="image/*"></div><div class="col-md-4 required"><input type="text" class="form-control" id="hotel_text'+h+'" name="hotels['+h+'][hotel_text]" placeholder="Days" required></div><div class="col-md-2"><a class="ms-1 btn btn-sm btn-outline-danger px-1 remove_hotel_field" data-hotel-no="'+c+'"><i class="bx bxs-trash"></i></a></div></div></div>';
            $(hotel_wrapper).append(html);

            $('#type_id'+h).select2({
                theme: 'bootstrap4',
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
                allowClear: Boolean($(this).data('allow-clear')),
            });
             
            h++;
        });
        $(hotel_wrapper).on("click",".remove_hotel_field", function(e){ //user click on remove text
            e.preventDefault(); 
            var city_num = $(this).attr('data-hotel-no');
            alert(city_num);
            $('#input_hotel_fields_wrap_'+city_num).remove();
        });





        //pakage city
        var city_wrapper         = $("#input_city_fields_wrap"); //Fields wrapper
        var add_city_button      = $(".add_city_field_button"); //Add button ID
        var c = 1;
        
        
        $(add_city_button).click(function(e){ //on add input button click
            var state_id = $('#state_id').val();
            var actionUrl = $(document).find('.fetchCityActionUrl').val();
            //alert(state_id);
            e.preventDefault();
            var html = '';
            html +='<div class="input-field-wrap" id="input_city_fields_wrap_'+c+'"><div class="row"><div class="col-md-5 required"><select class="form-select city-id" id="city_id_'+c+'" data-placeholder="Choose city" name="cities['+c+'][city_id]" required><option value="">Choose city</option>';
                <?php foreach ($cities as $key => $city):?>
                   html +='<option value="{{ $city->id }}">{{ $city->name }}</option>';
               <?php endforeach ?>
           
            // $.ajax({
            //     url: actionUrl,
            //     method: 'POST',
            //     data: {id:state_id},
            //     success: function(data) {
            //         result = data.response.cities;
            //         $.each(result, function(index, value) {
            //             console.log(value.id);
            //             console.log(value.name);
            //             $('#city_id_'+c).append($('<option></option>').val(value.id).html(value.name))
            //         });
                    // for (var index = 0; index <= result.length; index++) {
                    //     console.log(result[index].id);
                    //     $('#city_id_'+c).append('<option value="' + result[index].id + '">' + result[index].name + '</option>');
                    // }
                //    $.each(data.response.cities, function(key,val) {   
                //     console.log(val.name);  
                            
                //         //html +='<option value="'+val.id+'">'+val.name+'</option>';
                //        html +=options.append($("<option />").val(val.id).text(val.Name));    
                //     });     
            //     }
            // });
               
            html +='</select></div><div class="col-md-5 required"><input type="text" class="form-control city-duration" id="city_duration_'+c+'" name="cities['+c+'][city_duration]" placeholder="Days" required></div><div class="col-md-2"><a class="ms-1 btn btn-sm btn-outline-danger px-1 remove_city_field" data-city-no="'+c+'"><i class="bx bxs-trash"></i></a></div></div></div>';
            $(city_wrapper).append(html);

            $('#city_id_'+c).select2({
                theme: 'bootstrap4',
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
                allowClear: Boolean($(this).data('allow-clear')),
            });
             
            c++;
        });
        $(city_wrapper).on("click",".remove_city_field", function(e){ //user click on remove text
            e.preventDefault(); 
            var city_num = $(this).attr('data-city-no');
            $('#input_city_fields_wrap_'+city_num).remove();
        });

        $('form#createForm').on('submit', function(event) {
            $('#title').each(function() {
                $(this).rules("add", 
                {
                    required: true,
                    messages: {
                        required: "This field is required",
                    }
                });
            });
            $('#category_id').each(function() {
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
            $('#language_id').each(function() {
                $(this).rules("add", 
                {
                    required: true,
                    messages: {
                        required: "This field is required",
                    }
                });
            });
            $('.city-id').each(function() {
                $(this).rules("add", 
                {
                    required: true,
                    messages: {
                        required: "This field is required",
                    }
                });
            });
            $('.city-duration').each(function() {
                $(this).rules("add", 
                {
                    required: true,
                    digits: true,
                    messages: {
                        required: "This field is required",
                    }
                });
            });
            $('#tag_id').each(function() {
                $(this).rules("add", 
                {
                    required: true,
                    messages: {
                        required: "This field is required",
                    }
                });
            });
            $('.price-field').each(function() {
                $(this).rules("add", 
                {
                    required: true,
                    digits: true,
                    messages: {
                        required: "This field is required",
                    }
                });
            });
            $('#duration').each(function() {
                $(this).rules("add", 
                {
                    required: true,
                    messages: {
                        required: "This field is required",
                    }
                });
            });
            $('#total_price').each(function() {
                $(this).rules("add", 
                {
                    required: true,
                    digits: true,
                    messages: {
                        required: "This field is required",
                    }
                });
            });
            $('#lowest_price').each(function() {
                $(this).rules("add", 
                {
                    required: true,
                    digits: true,
                    messages: {
                        required: "This field is required",
                    }
                });
            });
            $('#short_description').each(function() {
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
            $('#img').each(function() {
                $(this).rules("add", 
                {
                    required: true,
                    messages: {
                        required: "This field is required",
                    }
                });
                
            });
            $('.pakage-feature').each(function() {
                $(this).rules("add", 
                    {
                        required: true,
                        messages: {
                            required: "This field is required",
                        }
                    });
            });
    
        });

        $("#createForm").validate({
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