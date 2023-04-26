//*
// ** Перенос написаного текста в другой блок, сохрание аватарки
// *

function t_filling(text)
{
    document.getElementById('description-target').innerHTML = text;
}

function n_filling(text)
{
    document.getElementById('description-name').innerHTML = text;
}

function s_filling(text)
{
    document.getElementById('description-surname').innerHTML = text;
}

// сохранение изображения - аватарки
function save_avatar() {
   // alert(new FormData($('#personal_data')[0]));
    $.ajax({
        url: '/medicalBook/web/personal-data/avatar',
        type: 'POST',
        data: new FormData($('#personal_data')[0]),
        processData: false,
        contentType: false,
        success: function(response) { //Данные отправлены успешно
            console.log(response)
            $('#avatar img').attr('src', response);
            $('#value_avatar').val(response);
        },
        error: function(response) { // Данные не отправлены
            alert("Ошибка. Данные не отправленны."+response);
        }
    });
}

