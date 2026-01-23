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
    Название компании: {{ $data['company'] ?? null  }}<br>
    Имя: {{ $data['name'] ?? null  }}<br>
    Электронная почта: {{ $data['email'] ?? null  }}<br>
    Телефон: {{ $data['phone'] ?? null }}<br>
</p>

<h2>
    Позиция
</h2>

<p>
    Маркировка: {{ $data['nomenclature'] ?? null }}<br>
    Количество: {{ $data['count'] ?? null  }}<br>
    Ед.упаковки: {{  $data['unit'] ?? null  }}<br>
</p>

@if($data['message'])
    <h2>
        Соообщение
    </h2>

    <p>
        {{  $data['message']  }}
    </p>
@endif()

</body>
</html>
