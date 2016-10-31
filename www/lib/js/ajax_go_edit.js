/**
 * Created by Евгения on 31.10.2016.
 */


$(document).ready(function() {
    /*---------------------------User Person Information (Edit)------------*/
    $('#formx').submit(function(e) {
        var $form = $(this);
        var name = document.getElementById("name");
        var education = document.getElementById("education");
        var address = document.getElementById("address");
        var phone = document.getElementById("phone");

        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data:{name: name,
                education: education,
                address: address,
                phone: phone
            }
        }).done(function() {
            console.log('success');
            $('#name').html(name);
            $('#education').html(education);
            $('#address').html(address);
            $('#phone').html(phone);
        }).fail(function() {
            console.log('fail');
        });
        //отмена действия по умолчанию для кнопки submit
        e.preventDefault();
    });


    /*---------------------------User Person Information (Edit)------------*/
});
