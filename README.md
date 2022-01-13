# tokenapi

Лёгкая система для генерации TOKEN для данных принятых методом POST.
###########################################################################################
Для начала работы потребуется:
1. Создать таблицу с столбцами: `result` - в нём будет храниться сам ключ; `data` - привязанные к сгенерированному ключу данные.
2. Изменить файл base.php, заменив: 'host' - на адрес сервера с вашей базой данных; 'user' - на пользователя базы данных под которым будут происходить манипуляции внесения и чтения данных; 'pass' - пароль пользователя; 'base' - база данных в которой хранится таблица.
###########################################################################################

#Система принемает следующие POST параметры для метода generate:
Обязательный параметр - data, которым должна быть передана информация, для корой и будет сгенерирован токен.
Параметры вариантивности генерации ключа: type; len; list;
type имеет следующие варианты генерации:
  - both (используется по умолчанию) - смешанный тип. Генерируемый токен будет содержать цифренно-буквенные значения в различные регистрах.
  - str - строчный тип. Генерируемый токен будет содержать только буквенные значения в различных регистрах.
  - numberic - числовой тип. Генерируемый токен будет содержать цифровые значения.
  - guid - стандартизованный тип. Генерируемый токен будет содержать цифренно-буквенные значения в разных регистрах, длиной 32 символа окружённых фигурными скобками и разделёнными по 8-4-4-4-12 символов.
  - input - вводимый тип. Генерируемый токен будет содержать только те символы, которые переданы в ключе 'list';
len - принимает требуемую длину сгенерированного ключа, но превышающую 16 символов.
list - принимается набор символов, которые требуется использовать при генерации ключа.

#Система принимает следующие GET параметры для метода retrieve:
  - id - сгенерированный токен, по которому мы хотим получить обратно переданную в методе generate информацию.
