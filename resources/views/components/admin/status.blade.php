<script>
    $(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
        });

        $("body").on('change', '.changeStatus', function(){    // 3rd way
       
            var status = $(this).data('value');  
            var id = $(this).data('id');
            var actionUrl = $(document).find('.statusActionUrl').val();
            $.ajax({
            type: "POST",
            url: actionUrl,
            data: { status:status,id:id},
            beforeSend: function(){
                
            },
            success: function (res) {
                if(res.status == true){  
                    $('#dataTable').DataTable().ajax.reload();
                    Toast.fire({
                        icon: 'success',
                        title: res.success_msg
                    })
                }else{
                    Toast.fire({
                        icon: 'error',
                        title: res.error_msg
                    })
                }
            
            }
            });
        });
    });
</script>