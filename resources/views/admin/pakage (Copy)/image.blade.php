<form class="row g-3" id="createForm" method="post" action="{{ route('admin.pakage.image.store',['id' => $item->id]) }}" enctype="multipart/form-data">
    @csrf
    <div class="col-md-12 required">
        <label for="img" class="form-label">Image</label>
        <div class="input-group mb-3">
            <input type="file" class="form-control" name="file[]" id="img" accept="image/*" multiple required>
        </div>
    </div>
    <div class="col-md-12">
        <div class="row mb-3 row-cols-auto g-2 justify-content-center mt-3 preview-images-zone">
            @foreach($item->pakage_images as $rowImage)
            @if($rowImage->file_path !=='')
                <div class="col">
                    <img src="{{ $rowImage->file_path_url }}" width="100" height="100" class="border rounded cursor-pointer" alt="">
                    <a href="javascript:;" class="delete-image" data-pakage-id="{{ $item->id }}" data-action-url="{{route('admin.pakage.delete.image',['id'=> $rowImage->id])}}"><span class="icon"><i class="fas fa-trash-alt" style="color: red"></i></span></a>
                    <div class="form-check">
                        <input class="form-check-input default-image" type="radio" data-action-url="{{route('admin.pakage.default.image.set',['id'=> $item->id])}}" name="default_status" value="{{$rowImage->id}}" id="flexRadioDefault{{$rowImage->id}}" @if($rowImage->default_status == 1){{'checked'}}@endif>
                        <label class="form-check-label" for="flexRadioDefault{{$rowImage->id}}">
                          Main Image
                        </label>
                      </div>
                </div>
            @else
                <div class="col"><img src="{{ asset('backend/assets/images/no-image.jpg') }}" width="70" class="border rounded cursor-pointer" alt=""></div>
            @endif
            @endforeach
        </div>
    </div>
    
    <div class="col-md-12">
        <div class="d-md-flex d-grid align-items-center gap-3">
            <button type="submit" class="btn btn-primary px-4">Save</button>
        </div>
    </div>
</form>
<style>
 .col {
  display: inline-block;
  position: relative;
}
  a .icon {
  position: absolute;
  right: 0;
  top: 0;
  line-height: 0;
}
</style>

<script src="{{ asset('admin/assets/plugins/validation/jquery.validate.min.js') }}"></script>
<script>
    $(document).ready(function() {
       function readURL(input) {
           if (input.files && input.files[0]) {
               var filesAmount = input.files.length;
               let i;
               for (i = 0; i < filesAmount; i++) {
                   var reader = new FileReader();

                   reader.onload = function(e) {
                       var html = '<div class="col"><img src="' + e.target.result + '" class="rounded float-start no-image-preview"></div>';
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
    $(function(){
        
        $('#createForm').validate({
            ignore: [],
            debug: false,
            rules: {
                'file[]': {
                    required: true,
                }
            },
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

        $('.default-image').click(function(event) {
          var id = $('input[name="default_status"]:checked').val();
          event.preventDefault();
          Swal.fire({
                
                text: "Are you sure you would like to change default image?",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-outline-secondary"
                },
                buttonsStyling: !1
            }).then((willDelete) => {
                var actionUrl = $(this).attr("data-action-url");
                if (willDelete.dismiss !='cancel') {
                    $.ajax({
                        url:actionUrl,
                        data : {'id' : id},
                        type:"POST",
                        success: function(res) {
                            if(res.response.status == true){ 
                                Swal.fire({
                                    icon: "success",
                                    title: res.response.title,
                                    text: res.response.success_msg,
                                    customClass: {
                                        confirmButton: "btn btn-success"
                                    }
                                }).then((isConfirmed) => {
                                    window.location.reload();
                                });
                            }
                        }    
                    });
                }else{
                    Swal.fire({
                        title: "Cancelled",
                        text: "Default Image Set Cancelled!!",
                        icon: "error",
                        customClass: {
                            confirmButton: "btn btn-success"
                        }
                    })
                }
            });
        });

        $('body').on('click', '.delete-image', function(event) {

        //$('.delete-image').click(function(event) {
          event.preventDefault();
          Swal.fire({
                text: "Are you sure you would like to delete image?",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-outline-secondary"
                },
                buttonsStyling: !1
            }).then((willDelete) => {
                var actionUrl = $(this).attr("data-action-url");
                var pakage_id = $(this).attr("data-pakage-id");
                if (willDelete.dismiss !='cancel') {
                    $.ajax({
                        url:actionUrl,
                        data : {'pakage_id' : pakage_id},
                        type:"POST",
                        success: function(res) {
                            if(res.response.status == true){ 
                                Swal.fire({
                                    icon: "success",
                                    title: res.response.title,
                                    text: res.response.success_msg,
                                    customClass: {
                                        confirmButton: "btn btn-success"
                                    }
                                }).then((isConfirmed) => {
                                    //window.location.reload();
                                    $('.preview-images-zone').html(res.response.html)
                                });
                            }else{
                                Swal.fire({
                                    icon: "error",
                                    title: res.response.title,
                                    text: res.response.error_msg,
                                    customClass: {
                                        confirmButton: "btn btn-success"
                                    }
                                })
                            }
                        }    
                    });
                }else{
                    Swal.fire({
                        title: "Cancelled",
                        text: "Delete Image Cancelled!!",
                        icon: "error",
                        customClass: {
                            confirmButton: "btn btn-success"
                        }
                    })
                }
            });
        });
    });
</script>