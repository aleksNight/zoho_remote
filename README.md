# Удаленный доступ к Zoho на базе laravel
 Регистрируемся на Zoho</br>
 Переходим https://api-console.zoho.com/</br>
 Выбираем self client, тем самым получив client id и client secret</br>
 Генерируем код со scope-ом - ZohoCRM.modules.ALL,ZohoCRM.settings.ALL,ZohoCRM.users.All </br>
 Далее вводим данные на главной странице проекта. </br>
 Данные записываются в базу и мы получаем доступ к апи.</br>
 Так как access_token сбрасывается каждый час, то пишем его в cookie с таймаутом, по истечению которого происходит обновление.</br>
 Следующим шагом тянем данные из Zoho. </br>
 Так как проект тестовый, то тянем только пару справочников и записи Deals и Activity.</br>
 Далее, на основании справочных данных формируем записи. </br>
 Сохранение, редактирование и удаление реализовано сквозное, как в локальной так и во внешней базе. </br>

 На реализацию ушло плюс минус 7 дней. 

