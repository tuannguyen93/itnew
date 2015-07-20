$(document).ready(function(){
    $('#email').change(function() {
        var email = $(this).val();
        if(email.length > 8) {
            $('#available').html('<span class="check"> Đang kiểm tra...</span>');
            
            $.ajax({
                type: "get",
                url: "check.php",
                data: "email="+ email, 
                success: function(response) {
                    if(response == "YES") {
                        $('#available').html('<span class="avai">Email có thể được sử dụng.</span>');
                    } else if (response == "NO") {
                        $('#available').html('<span class="not-avai">Email đã được sử dụng. Vui lòng chọn email khác.</span>');
                    }
                }
            });
        } else {
            $('#available').html('<span class="short">Email không hợp lệ.</span>');
        }
    });
});