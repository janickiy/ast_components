<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
</head>
<body>
<h1>
    Заявка к участию в тендере
</h1>
<p>
    Название компании: {{ $data['company'] ?? null }}<br>
    Имя: {{ $data['name'] ?? null }}<br>
    Электронная почта: {{ $data['email'] ?? null }}<br>
    Телефон: {{ $data['phone'] ?? null }}<br>
    Площадка: {{ $data['platform'] ?? null }}<br>
    Номер извещения о закупочной процедуре: {{ $data['numb'] ?? null }}<br><br>
    Соообщение: {{ $data['message'] ?? null  }}
</p>

</body>
</html>