<h1>Здравствуйте</h1>
<h2>Задание №1</h2>

SELECT users.name, COUNT(phone_numbers.phone) as phone_count FROM users<br/>
LEFT JOIN phone_numbers ON phone_numbers.user_id = users.id<br/>
WHERE users.gender = 2 AND users.birth_date < UNIX_TIMESTAMP(NOW() - INTERVAL 18 year) AND users.birth_date > UNIX_TIMESTAMP(NOW() - INTERVAL 22 year)
GROUP BY users.name;

<h2>Задание №2</h2>
<ul>
<li>В исходном коде не было проверки ошибки подключения к базе, не было проверки $_GET на наличие.</li>
<li>Не рационально делать множество запросов к бд в цикле, можно получить данные в один запрос.</li>
<li>Из уязвимостей: не рекомендуется хранить реквизиты базы данных в коде, должна быть экранизация $_GET.</li>
<li>Так же не рекомендуется использовать html внутри php (MVC).</li>
<li>Не выводилось сообщение если пользователи с данными id отсутствуют.</li>
</ul>

<h2>Связь со мной</h2>
tg:limorte
