$(document).ready(function () {
   
    $(".themeStyleChange").click(function(e){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var  className = $('html').attr('class');
        if(className == 'light-theme'){
            var value = 0;
        }else{
            var value = 1;
        }
        var actionUrl = $(document).find('.actionThemeStyleUrl').val();
        
        $.ajax({
            url: actionUrl,
            type:"POST" ,
            data: {
                value:value
            },
            success:function(response)
            {
                if(response){
                    console.log(response.success);
                }else{
                    console.log('error');
                }
            }
        });
    });
    $(document).on('click', '.openPopup', function(){
        let url = $(this).attr('data-action-url');
        var title = $(this).attr('data-title');
        // AJAX request
        $.ajax({
            url: url,
            type: 'get',
            beforeSend: function(){
            
            },
            success: function (response) {
                $('#dynamicAjaxModalBody').html(response.html);
                $('#ajaxModalLabel').html(title);
                $("#ajaxModal").modal('show');
            }
        });
       
    });
    
    setTimeout(function () {
        $("#alertHide").remove();
    }, 5000);
    
    
    $('.table-responsive').on('show.bs.dropdown', function () {
        $('.table-responsive').css( "overflow", "inherit" );
   });
   
   $('.table-responsive').on('hide.bs.dropdown', function () {
        $('.table-responsive').css( "overflow", "auto" );
   })
});

function deleteConfirm(route, modalBody, modalTtile){
    $('#deleteConfirmLabel').html(modalTtile);
    $('#deleteModalBody').html(modalBody);
    $(document).find('#deleteForm').attr('action',route);
}

function defaultTheme() {
    $('html').attr('class', '');
}

function checkall(){
    var id=[];
    if ($("#multi_check").is(':checked')) {
      $(".single_check").each(function () {
          $(this).prop("checked", true);
      });    
    } else {
      $(".single_check").each(function () {
          $(this).prop("checked", false);
      });
    }
}

function myfunction(ids){
    alert(ids);
}

$(document).ready(function(){
   
    $(document).on('click', '.single_check', function() { 
      $("#multi_check").prop("checked", false);
            var i = 0;
        $(".single_check").each(function () {
            if(!$(this).is(':checked')) {
                i = 1;
            }
        });
        if(i == 0){
            $("#multi_check").prop("checked", true);
        }
     });

     $('#select_action').change(function(){ 
        var action_value = $(this).val();
       
        if(action_value !=''){
          $('#apply_action').removeClass('disabled');
        }else{
          $('#apply_action').addClass('disabled');
        }
    });

    $(document).on('click', '.applyAction', function() { 
        
      var actionUrl = $(document).find('.actionUrl').val();
      var action_value = $('#select_action option:selected').val();
      var ids = [];
      $.each($("input[name='single_check']:checked"), function(){
          ids.push($(this).val());
      });
      console.log(action_value);
      console.log(ids);
      if($.isEmptyObject(ids)) {
        
        Lobibox.notify('error', {
            pauseDelayOnHover: true,
            size: 'mini',
            sound: false,
            rounded: true,
            delayIndicator: false,
            icon: 'bx bx-x-circle',
            continueDelayOnInactiveTab: false,
            position: 'top right',
            msg: 'Please Checked At lest One item.'
        });
      }else{
          $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type: "POST",
              url: actionUrl,
              data: {action_value:action_value,ids:ids},
              beforeSend: function(){
                  ajaxindicatorstart();
              },
              success: function (res) {
                //console.log(res.response.response);
                  ajaxindicatorstop();
                  if(res.response.status==true){
                    
                    Lobibox.notify('success', {
                        pauseDelayOnHover: true,
                        size: 'mini',
                        rounded: true,
                        sound: false,
                        icon: 'bx bx-check-circle',
                        delayIndicator: false,
                        continueDelayOnInactiveTab: false,
                        position: 'top right',
                        msg: res.response.success_msg+'.'
                    });
                    setTimeout(function(){
                        window.location.href=res.response.response;
                      }, 1500);
                  
                  }
                  if(res.response.success == true && res.response.is_send_mail == true){
                    $('#dynamicAjaxModalBody').html(res.response.response);
                    $('#ajaxModalLabel').html('Send Mail');
                    $("#ajaxModal").modal('show');
                  }
              }
          });
      }
    });
});



