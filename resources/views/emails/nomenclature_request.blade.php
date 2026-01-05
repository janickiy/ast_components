<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
</head>
<body>
<h1>
    Запрос номенклатуры
</h1>

<h2>
    Контакты
</h2>

<p>
    Название компании: {{ $company }}<br>
    Имя: {{ $name }}<br>
    Электронная почта: {{ $email }}<br>
    Телефон: {{ $phone }}<br>
</p>

<h2>
    Позиция
</h2>

<p>
    Маркировка: {{ $label }}<br>
    Количество: {{ $count }}<br>
    Ед.упаковки: {{ $unit }}<br>
</p>

@if($message)
    <h2>
        Соообщение
    </h2>

    <p>
        {{ $message }}
    </p>
@endif()

</body>
</html>
