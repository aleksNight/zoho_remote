# Удаленный доступ к Zoho на базе laravel
 Регистрируемся на Zoho</br>
 Переходим https://api-console.zoho.com/</br>
 Выбираем self client, тем самым получив client id и client secret</br>
 Генерируем код со scope-ом - ZohoCRM.modules.ALL,ZohoCRM.settings.ALL,ZohoCRM.users.All 
 Далее вводим данные на главной странице проекта. 
 Данные записываются в базу и мы получаем доступ к апи.
 Так как access_token сбрасывается каждый час, то пишем его в cookie с таймаутом, по истечению которого происходит обновление.
 Следующим шагом тянем данные из Zoho. 
 Так как проект тестовый, то тянем только пару справочников и записи Deals и Activity.
 Далее, на основании справочных данных формируем записи. 
 Сохранение, редактирование и удаление реализовано сквозное, как в локальной так и во внешней базе. 

 На реализацию ушло плюс минус 7 дней. 

