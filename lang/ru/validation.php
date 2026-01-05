<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */
    //Поле :attribute должно быть принято, если :other имеет значение :value.
    'accepted' => 'Поле :attribute должно быть принято.',
    'accepted_if' => 'Поле :attribute должно быть принято, если :other имеет значение :value.',
    'active_url' => 'Поле :attribute должно быть допустимым URL-адресом.',
    'after' => 'Поле :attribute должно содержать дату после :date.',
    'after_or_equal' => 'Поле :attribute должно содержать дату, следующую за :date или равную ей.',
    'alpha' => 'Поле :attribute должно содержать только буквы.',
    'alpha_dash' => 'Поле :attribute должно содержать только буквы, цифры, тире и символы подчеркивания.',
    'alpha_num' => 'Поле :attribute должно содержать только буквы и цифры.',
    'any_of' => 'Поле :attribute недопустимо.',
    'array' => 'Поле :attribute должно быть массивом.',
    'ascii' => 'Поле :attribute должно содержать только однобайтовые буквенно-цифровые символы.',
    'before' => 'Поле :attribute должно содержать дату, предшествующую :date.',
    'before_or_equal' => 'Поле :attribute должно содержать дату, предшествующую или равную :date.',
    'between' => [
        'array' => 'Поле :attribute должно содержать от :min до :max элементов.',
        'file' => 'Размер поля :attribute должен составлять от :min до :max килобайт.',
        'numeric' => 'Поле :attribute должно быть в диапазоне от :min до :max.',
        'string' => 'Поле :attribute должно содержать от :min до :max символов.',
    ],
    'boolean' => 'Поле :attribute должно иметь значение true или false.',
    'can' => 'Поле :attribute содержит несанкционированное значение.',
    'confirmed' => 'Поле :attribute подтверждение  не соответствует.',
    'contains' => 'В поле :attribute отсутствует требуемое значение.',
    'current_password' => 'Введен неверный пароль.',
    'date' => 'В поле :attribute должна быть указана действительная дата.',
    'date_equals' => 'Поле :attribute должно содержать дату, равную :date.',
    'date_format' => 'Поле :attribute должно соответствовать формату :format.',
    'decimal' => 'Поле :attribute должно содержать :decimal разряды после запятой.',
    'dimensions' => 'Поле :attribute должно быть отклонено.',
    'declined_if' => 'Поле :attribute должно быть отклонено, если :other равно :value.',
    'different' => 'Поле :attribute и :other должны отличаться.',
    'digits' => 'Поле :attribute должно быть :digits цифры.',
    'digits_between' => 'Поле :attribute должно быть :digits цифры. :in поле атрибута должно быть от :min до :max цифр.',
    'размеры' => 'Поле :attribute имеет недопустимые размеры изображения.',
    'doesnt_contain' => 'Поле :attribute должно не содержит ни одного из следующих: :values.',
    'doesnt_end_with' => 'Поле :attribute не должно заканчиваться одним из следующих: :values.',
    'doesnt_start_with' => 'Поле :attribute не должно начинаться с одного из следующих: :values.',
    'email' => 'Поле :attribute должно быть действительным адресом электронной почты.',
    'encoding' => 'Поле :attribute должно быть закодировано в :encoding.',
    'ends_with' => 'Поле :attribute должно заканчиваться одним из следующих: :values.',
    'enum' => 'Выбранный :attribute недействителен.',
    'exists' => 'Выбранный :attribute недействителен.',
    'extensions' => 'Поле :attribute должно иметь одно из следующих расширений: :values.',
    'file' => 'Поле :attribute должно быть файлом.',
    'filled' => 'Поле :attribute должно иметь значение.',
    'gt' => [
        'array' => 'В поле :attribute должно быть больше, чем :value элементов.',
        'file' => 'В поле :attribute должно быть больше, чем :value килобайт.',
        'numeric' => 'В поле :attribute должно быть больше, чем :value.',
        'string' => 'В поле :attribute должно быть больше :value символов.',
    ],
    'gte' => [
        'array' => 'Поле :attribute должно содержать :value элементов или более.',
        'file' => 'Поле :attribute должно быть больше или равно :value в килобайтах.',
        'numeric' => 'Поле :attribute должно быть больше или равно :value.',
        'string' => 'Поле :attribute должно быть больше или равно :value значения.',
    ],
    'hex_color' => 'В поле :attribute должен быть допустимый шестнадцатеричный цвет.',
    'image' => 'В поле :attribute должно быть изображение.',
    'in' => 'Выбранный :attribute недопустим.',
    'in_array' => 'Поле :attribute должно существовать в :other.',
    'in_array_keys' => 'Поле :attribute должно содержать по крайней мере один из следующих ключей: :values.',
    'integer' => 'Поле :attribute должно быть целым числом.',
    'ip' => 'В поле :attribute должен быть действительный IP-адрес.',
    'ipv4' => 'В поле :attribute должен быть действительный IPv4-адрес.',
    'ipv6' => 'В поле :attribute должен быть действительный IPv6-адрес.',
    'json' => 'Поле :attribute должно быть допустимым в формате JSON.',
    'list' => 'Поле :attribute должно быть списком.',
    'lowercase' => 'Поле :attribute должно быть строчным.',
    'lt' => [
        'array' => 'В поле :attribute должно быть меньше, чем :value элементов.',
        'file' => 'В поле :attribute должно быть меньше, чем :value килобайт.',
        'numeric' => 'В поле :attribute должно быть меньше, чем :value.',
        'string' => 'В поле :attribute должно быть меньше :value символов .',
    ],
    'lte' => [
        'array' => 'В поле :attribute должно быть не более :value.',
        'file' => 'Поле :attribute должно быть меньше или равно :value в килобайтах.',
        'numeric' => 'Поле :attribute должно быть меньше или равно to :value.',
        'string' => 'Поле :attribute должно быть меньше или равно :value символам .',
    ],
    'mac_address' => 'Поле :attribute должно содержать действительный MAC-адрес.',
    'max' => [
        'array' => 'Поле :attribute не должно содержать более :max элементов.',
        'file' => 'Поле :attribute не должно превышать :max килобайт.',
        'numeric' => 'Поле :attribute не должно превышать :max.',
        'string' => 'В поле :attribute не должно быть больше :max символов.',
    ],

    'max_digits' => 'В поле :attribute должно быть не более :max цифр.',
    'mimes' => 'Поле :attribute должно быть файлом типа: :values.',
    'mimetypes' => 'Поле :attribute должно быть файлом типа: :values.',
    'min' => [
        'array' => 'В поле :attribute должно быть не менее :min элементов.',
        'file' => 'В поле :attribute должно быть не менее :min килобайт.',
        'numeric' => 'В поле :attribute должно быть не менее :min.',
        'string' => 'В поле :attribute должно быть не менее :min символов.',
    ],

    'min_digits' => 'В поле :attribute должно быть не менее :min цифр.',
    'missing' => 'Поле :attribute должно отсутствовать.',
    'missing_if' => 'Поле :attribute должно отсутствовать, когда :другое равно :value.',
    'missing_unless' => 'Поле :attribute должно отсутствовать, если только :other не является :value.',
    'missing_with' => 'Поле :attribute должно отсутствовать, когда присутствует :values.',
    'missing_with_all' => 'Поле :attribute должно отсутствовать, когда присутствуют :values.',
    'multiple_of' => 'Значение поля :attribute должно быть кратно :value.',
    'not_in' => 'Выбранный :attribute недопустим.',
    'not_regex' => 'Формат поля :attribute недопустим.',
    'numeric' => 'Значение :attribute поля должно быть числом.',
    'password' =>
        [
            "letters" => "Поле :attribute должно содержать хотя бы одну букву.",
            "mixed" => "Поле :attribute должно содержать как минимум одну заглавную и одну строчную букву.",
            "numbers" => "Поле :attribute должно содержать как минимум одно число.",
            'symbols' => 'Поле :attribute должно содержать хотя бы один символ.',
            'uncompromised' => 'Данный :attribute появился в результате утечки данных. Пожалуйста, выберите другой :attribute.',
        ],
    'present' => 'Должно присутствовать поле :attribute.',
    'present_if' => 'Поле :attribute должно присутствовать, когда :other равно :value.',
    'present_unless' => 'Поле :attribute должно присутствовать, если :other не равно :value.',
    'present_with' => 'Поле :attribute должно присутствовать при наличии :values.',
    'present_with_all' => 'Поле :attribute должно присутствовать при наличии :values.',
    'prohibited' => 'Поле :attribute запрещено.',
    'forbidden_if' => 'Поле :attribute запрещено, когда :другое имеет значение.',
    'forbidden_if_accepted' => 'Поле :attribute запрещено, когда :другое принято.',
    'forbidden_if_declined' => 'Поле :attribute запрещено, когда :другое отклонено.',
    'forbidden_unless' => 'Поле :attribute запрещено, если :other не указано в :values.',
    'prohibits' => 'Поле :attribute запрещает :other присутствовать.',
    'regex' => 'Формат поля :attribute недопустим.',
    'required' => 'Поле :attribute является обязательным.',
    'required_array_keys' => 'Поле :attribute должно содержать записи для: :values.',
    'required_if' => 'Поле :attribute является обязательным, когда :другое - это :значение.',
    'required_if_accepted' => 'Поле :attribute требуется, когда :другое принято.',
    'required_if_declined' => 'Поле :attribute требуется, когда :другое отклонено.',
    'required_unless' => 'Поле :attribute требуется, если :другое не указано в :values.',
    'required_with' => 'Поле :attribute требуется при наличии :values.',
    'required_with_all' => 'Поле :attribute требуется при наличии :values.',
    'required_without' => 'Поле :attribute требуется, когда :values отсутствует.',
    'required_without_all' => 'Поле :attribute требуется, когда ни одно из :значений не присутствует.',
    'same' => 'Поле :attribute должно соответствовать :other.',
    'size' => [
        'array' => 'Поле :attribute должно содержать :size элементов.',
        'file' => 'Поле :attribute должно иметь :size в килобайтах.',
        'numeric' => 'Поле :attribute должно иметь :size.',
        'string' => 'Поле :attribute должно содержать :size символов.',
    ],
    'starts_with' => 'The :attribute field must start with one of the following: :values.',
    'string' => 'The :attribute field must be a string.',
    'timezone' => 'The :attribute field must be a valid timezone.',
    'unique' => 'The :attribute has already been taken.',
    'uploaded' => 'The :attribute failed to upload.',
    'uppercase' => 'The :attribute field must be uppercase.',
    'url' => 'The :attribute field must be a valid URL.',
    'ulid' => 'The :attribute field must be a valid ULID.',
    'uuid' => 'The :attribute field must be a valid UUID.',
    'starts_with' => 'Поле :attribute должно начинаться с одного из следующих значений.',
    'string' => 'Поле :attribute должно быть строкой.',
    'timezone' => 'Поле :attribute должно быть допустимым часовым поясом.',
    'unique' => ':attribute взят.',
    'uploaded' => 'Поле :attribute не удалось загрузить.',
    'uppercase' => 'Поле :attribute должно быть прописным.',
    'url' => 'Поле :attribute должно быть допустимым URL.',
    'ulid' => 'В поле :attribute должен быть действительный ULID.',
    'uuid' => 'В поле :attribute должен быть действительный UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
