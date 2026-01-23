<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
</head>
<body>
<h1>
    Сообщение с сайта
</h1>
<p>
    Имя: {{ $data['name'] ?? null }}<br>
    Электронная почта: {{ $data['email'] ?? null }}<br>
    Телефон: {{ $data['phone'] ?? null }}<br>
</p>
<h2>
    Соообщение
</h2>

<p>
    {{  $data['message']  }}
</p>

</body>
</html>