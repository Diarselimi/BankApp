### BANK APP API
This app has two methods in the api

For all requests you will get a response code `Success = 200 ` or `Bad Request = 400`

Type | Url | Body | Response
---|---|--- | ---
POST| /bank/transaction/add | ```{"amount": "123.123", "bookingDate": "2018-11-18 13:00:22", "parts":[{"amount": "123.12", "reason": "debtor_payback"}]}``` | `{"message": "success", "uuid": "123456"}`
GET | /bank/transaction/uuid| | `{"id": 1, "uuid": 123123, "amount": "123.3", "bookingDate": "2018-11-18 13:00:22", "parts":[{"amount": "123.12", "reason": "debtor_payback"}]}`

##### Requirements
1. `PHP 7.1 with sqlite3 extension`
##### How to run the project 
1.  `composer update`
2.  `bin/console doctrine:database:create`
3.  `bin/console doctrine:schema:create`
4.  `./vendor/bin/phpunit tests/` to run the tests.
5.  `cd public/ & php -sS localhost:8000`