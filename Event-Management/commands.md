SAIL UP //
./vendor/bin/sail up 
SAIL DOWN// 
./vendor/bin/sail down

LARASTAN CHECK
./vendor/bin/phpstan analyse

RUNNING PINT
./vendor/bin/sail pint



||
RUTAS
--Event Planner--
register : http://localhost/register
login  :  http://localhost/login

--Events--
  PUT       http://localhost/api/event/${id} ..... event.update 
  DELETE    http://localhost/api/event/${id} ..... event.delete
  POST      http://localhost/api/event/create .... event.create
  GET|HEAD  http://localhost/api/event/detail/${id} event.show
  GET|HEAD  http://localhost/api/event/list  event.index