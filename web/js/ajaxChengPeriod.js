
function cheng_period(event) {
    event.preventDefault();

        $.ajax({
            type: 'POST',
            url: '/medicalBook/web/user-params/views',
            data: new FormData($('#cheng_period')[0]),
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log('response + ')
                console.log(response)
                //$('#card-body').html(response);
                //$('#cheng_chart').addClass('qqq');
                //$('.card-title').addClass('qqq');
               // $.pjax.reload({container: '#boxPjax', async: true});
            },
            error: function (response) { // Данные не отправлены
                alert("Ошибка. Данные не отправленны." + response);
            }
        })
}

