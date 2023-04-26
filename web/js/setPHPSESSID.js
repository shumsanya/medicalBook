//*
// ** Created user
// *
$(function ()
{
    $.ajax({
        //  исправить ссылку на корневой каталог
        url: 'http://localhost/medicalBook/web/api/setusersession',
        type: 'post',
        data: {
            '': '',
            _csrf: 'Yii::$app->request->getCsrfToken()?>'
        },
        success: function(data) {
            console.log(' set user session ok ')
        }
    });
})
