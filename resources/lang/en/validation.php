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

    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'alpha'                => 'The :attribute may only contain letters.',
    'alpha_dash'           => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'            => 'The :attribute may only contain letters and numbers.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'The :attribute must be a date before :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => 'The :attribute confirmation does not match.',
    'date'                 => 'The :attribute is not a valid date.',
    'date_format'          => 'The :attribute does not match the format :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'The :attribute must be between :min and :max digits.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'The :attribute must be a valid email address.',
    'exists'               => 'The selected :attribute is invalid.',
    'filled'               => 'The :attribute field is required.',
    'image'                => 'The :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'The :attribute must be an integer.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => 'The :attribute may not be greater than :max characters.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'The :attribute must be at least :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'The :attribute must be at least :min characters.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => 'The :attribute must be a number.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'The :attribute format is invalid.',
    'required'             => 'The :attribute field is required.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'The :attribute has already been taken.',
    'url'                  => 'The :attribute format is invalid.',

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


        'userName' => [
            'required' =>   'Поле с именем обязательно должно быть заполнено',
            'max' =>        'Поле с именем не должно превышать длинны в :max символов',
            'regex' =>      'Можно использовать только русские и латинские символы, цифры, а также символы -_\'',

        ],

        'emailRegister' => [
            'required' =>   'Поле email обязательно должно быть заполнено',
            'email' =>      'Поле email должно быть существующим email-адресом',
            'max' =>        'Поле email не должно превышать длинны в :max символов',
            'unique' =>     'Пользователь с таким адресом электронной почты уже зарегстрирован',

        ],

        

        'passwordRegister' => [
            'required' =>   'Поле с паролем обязательно должно быть заполнено',
        ],

        'emailLogin' => [

            'required' =>   'Введите email',
            'email' =>      'Поле email должно быть существующим email-адресом',
            'max' =>        'Поле email не должно превышать длинны в :max символов',
            
        ],

        'passwordLogin' => [

            'required' =>   'Введите пароль',
            'min' =>        'Поле с паролем не должно быть меньше :min символов',
            'max' =>        'Поле с паролем не должно превышать длинны в :max символов',
        ],



        'emailResetPassword' => [
            'required' =>   'Введите email',
            'email' =>      'Поле email должно быть валидным email-адресом',
            'max' =>        'Поле email не должно превышать длинны в :max символов',
        ],

        'secretCode' => [
            'required' =>   'Введите секретный код',
            'alpha_num' =>  'Секретный код введён неверно',
            'size' =>        'Секретный код введён неверно',
        ],

        'passwordResetPassword' => [
            'required' =>   'Введите пароль',
            'min' =>        'Поле с паролем не должно быть меньше :min символов',
            'max' =>        'Поле с паролем не должно превышать длинны в :max символов',

        ],


























        'action' => [               // Общий для всех 
            'required'          => 'Отсутствует поле action',
            'string'            => 'Поле action не является строкой',
            'alpha_num'         => 'Поле action должно содержать только латинские символы и цифры',
            'in'                => 'Текущее значение поля action не входит в список допустимых значений', 
        ],

        'alias' => [                // Общий для всех 
            'required'          => 'Отсутствует поле alias',
            'string'            => 'Поле alias не является строкой',
            'regex'             => 'Значение поля alias не отвечает правилам регулярного выражения',
        ],

        'id' => [                   // Общий для всех 
            'required'          => 'Отсутствует id',
            'integer'           => 'id не является целочисленным значением',
            'digits_between'    => "Длина id не является длиной в допустимом диапазоне",
            'min'               => 'Скорее всего в id, после приведения типов, остался ноль'
        ],

        'queue' => [               // Общий для всех 
            'required'          => 'Отсутствует queue',
            'integer'           => 'queue не является целочисленным значением',
            'digits_between'    => "Длина queue не является длиной в допустимом диапазоне",
            'min'               => 'Скорее всего в queue, после приведения типов, остался ноль'
        ],

        'projectNewDescription' => [       // Admin/ProjectController.php
            'required'          => 'Отсутствует поле newDescription в request',
            'string'            => 'Значение поля newDescription не является строкой',
            'regex'             => 'Значение поля newDescription не отвечает правилам регулярного выражения',
        ],

        'projectWords' => [                // Admin/ProjectController.php
            'required'          => 'Отсутствует поле words в request',
            'array'             => 'В words должен быть передан массив',
        ],

        'projectWords.*.enW' => [          // Admin/ProjectController.php
            'required_with'     => 'Передан не правильный объект',
            'regex'             => 'Присутствуют не валидные данные в поле enW',
        ],

        'projectWords.*.ruW' => [          // Admin/ProjectController.php
            'required_with'     => 'Передан не правильный объект',
            'regex'             => 'Присутствуют не валидные данные в поле ruW',
        ],

        'projectDeletedArr' => [           // Admin/ProjectController.php
            'required'           => 'Отсутствует поле deletedArr в request',
            'array'              => 'В deletedArr должен быть передан массив',
        ],

        'projectDeletedArr.*.enW' => [     // Admin/ProjectController.php
            'required_with'      => 'Передан не правильный объект',
            'regex'              => 'Присутствуют не валидные данные в поле enW',
        ],

        'projectDeletedArr.*.ruW' => [     // Admin/ProjectController.php
            'required_with'     => 'Передан не правильный объект',
            'regex'             => 'Присутствуют не валидные данные в поле ruW',
        ],

        'audio' => [                // Admin/AudioController.php
            'array'             => 'audio - не массив',
        ],

        'audio.*' => [              // Admin/AudioController.php
            'file'              => 'В массиве передаваемых файлов есть нечто не являющееся файлом', 
        ],

        'delete_files' => [
            'array' => 'audio не массив',
        ],

        'delete_files.*' => [       // Admin/AudioController.php
            'string'            => 'Передаваемое значение не является строкой', 
            'regex'             => 'Передаваемое значение не отвечает регулярному выражению', 
        ],

        'oldName' => [              // Admin/AudioController.php
            'string'            => 'Передаваемое в oldName значение не является строкой',
            'regex'             => 'Передаваемое в oldName значение не отвечает регулярному выражению',
            'required_with'     => 'Отсутствует newName',
        ],

        'newName' => [              // Admin/AudioController.php
            'string'            => 'Передаваемое в newName значение не является строкой',
            'regex'             => 'Передаваемое в newName значение не отвечает регулярному выражению',
            'required_with'     => 'Отсутствует oldName',
        ],

        'dictionariesName' => [    // Admin/DictionariesController.php
            'required'          => 'Отсутствует поле name в запросе',
            'string'            => 'Передаваемое значение newDictionaryName не является строкой', 
            'regex'             => 'Передаваемое значение newDictionaryName не отвечает регулярному выражению', //:values :attribute
            'unique'            => 'В списке имён словарей уже существует словарь с таким именем',
        ],

        'dictionaryName' => [       // Admin/DictionaryController.php
            'string'            => 'Передаваемое значение name не является строкой', 
            'regex'             => 'Передаваемое значение name не отвечает регулярному выражению', //:values :attribute
            'required_with'     => 'Отсутствуют необходимые дополнительные поля '
        ],

        'dictionaryStatus' => [     // Admin/DictionaryController.php
            'in'                => 'Значение status должно быть СТРОКОЙ!!! true или false',
            'required_with'     => 'Отсутствуют необходимые дополнительные поля '
        ],

        'dictionaryQueue' => [     // Admin/DictionaryController.php
            'integer'           => 'Значение queue должно быть целочисленным',
            'digits_between'    => 'Длина queue не является длиной в допустимом диапазоне',
            'min'               => 'Скорее всего в queue, после приведения типов, остался ноль',
            'required_with'     => 'Отсутствуют необходимые дополнительные поля '
        ],

        'dictionaryQueueAction' => [// Admin/DictionaryController.php
            'in'                => 'Значение queueAction должно быть СТРОКОЙ!!! false, insert или replace',
            'required_with'     => 'Отсутствуют необходимые дополнительные поля '
        ],

        'dictionaryProjectId' => [  // Admin/DictionaryController.php
            'integer'           => 'Значение projectId должно быть целочисленным',
            'digits_between'    => 'Длина projectId не является длиной в допустимом диапазоне',
            'min'               => 'Скорее всего в projectId, после приведения типов, остался ноль',
            'required_with'     => 'Отсутствуют необходимые дополнительные поля '
        ],

        'projectsName' => [         // Admin/ProjectsController.php
            'required'          => 'Отсутствует поле name в запросе',
            'string'            => 'Поле name в запросе не является строкой',
            'unique'            => 'Проект с таким именем уже существует',
            'regex'             => 'Имя не прошло проверку регулярным выражением',
        ],

        'analysisWordsForCheck' => [ // Admin/AnalysisController.php
            'required'          => 'Отсутствует поле wordsForCheck в запросе',
            'array'             => 'Поле wordsForCheck в запросе должен быть массивом'
        ],

        'analysisWordsForCheck.*' => [ // Admin/AnalysisController.php
            'string'            => 'Значение елемента wordsForCheck должно быть строкой',
            'regex'             => 'Присутствуют не валидные данные в елементе массива wordsForCheck',
        ],

        'analysisIdProject' => [    // Admin/AnalysisController.php
            'required'          => 'Отсутствует id',
            'integer'           => 'id не является целочисленным значением',
            'digits_between'    => "Длина id не является длиной в допустимом диапазоне",
            'min'               => 'Скорее всего в id, после приведения типов, остался ноль'
        ],

        'analysisWords' => [        // Admin/AnalysisController.php
            'required'          => 'Отсутствует поле words в запросе',
            'array'             => 'Поле words в запросе должен быть массивом' 
        ],

        'analysisWords.*.enW' => [  // Admin/AnalysisController.php
            'required_with'     => 'Передан не правильный объект',
            'regex'             => 'Присутствуют не валидные данные в поле enW',
        ],

        'analysisWords.*.ruW' => [  // Admin/AnalysisController.php
            'required_with'     => 'Передан не правильный объект',
            'regex'             => 'Присутствуют не валидные данные в поле enW',
        ],










        'settingsParamsNum' => [  // Admin/SettingController.php
            'array'             => 'settingsParamsNum должен быть массивом, что-то неверно указанно в методе getCheckArray()',
        ],

        'settingsParamsNum.*' => [ // Admin/SettingController.php
            'required'          => 'Отсутствует запись о данном елементе в методе getCheckArray()',
            'integer'           => 'Елемент массива должен быть целочисленным значением',
            'digits_between'    => 'Елемент массива должен быть целочисленным значением с длинной в заданном диапазоне от :min до :max',
            
        ],

        'settingsParamsStr' => [  // Admin/SettingController.php
            'array'             => 'settingsParamsStr должен быть массивом, что-то неверно указанно в методе getCheckArray()',
        ],

        'settingsParamsStr.*' => [// Admin/SettingController.php
            'required'          => 'Отсутствует запись о данном елементе в методе getCheckArray()',
            'string'            => 'Елемент массива должен быть строкой',
            'regex'             => 'Елемент массива не отвечает регулярному выражению',
        ],


        'settingsParamsRadio' => [  // Admin/SettingController.php
            'array'             => 'settingsParamsRadio должен быть массивом, что-то неверно указанно в методе getCheckArray()',
        ],

        'settingsParamsRadio.*' => [// Admin/SettingController.php
            'required'          => 'Отсутствует запись о данном елементе в методе getCheckArray()',
            'string'            => 'Елемент массива должен быть строкой',
            'alpha_num'         => 'Елемент массива должен быть  alpha_num',
            'in'                => 'Елемент массива должен быть или true или false',

        ],

        'settingsParamsCheckbox' => [  // Admin/SettingController.php
            'array'             => 'settingsParamsCheckbox должен быть массивом, что-то неверно указанно в методе getCheckArray()',
        ],

        'settingsParamsCheckbox.*' => [// Admin/SettingController.php
            'required'          => 'Отсутствует запись о данном елементе в методе getCheckArray()',
            'string'            => 'Елемент массива должен быть строкой',
            'regex'             => 'Елемент массива не отвечает регулярному выражению',
        ],


        'articleTitle' => [        // Admin/ArticleController.php
            'required'          => 'Отсутствует поле title в $request',
            'string'            => 'Поле title в $request должно быть строкой',
            'regex'             => 'Поле title в $request не соответствует регулярному выражению',
            'unique'            => 'Поле title должно быть уникальным, в БД уже есть статья с тами именем',
        ],

        'articleSecond_title' => [// Admin/ArticleController.php
            'required'          => 'Отсутствует поле second_title в $request',
            'string'            => 'Поле second_title в $request должно быть строкой',
            'regex'             => 'Поле second_title в $request не соответствует регулярному выражению',
        ],

        'articleAlias' => [       // Admin/ArticleController.php
            'required'          => 'Отсутствует поле params[\'alias\'] в $request',
            'string'            => 'Поле params[\'alias\'] в $request должно быть строкой',
            'regex'             => 'Поле params[\'alias\'] в $request не соответствует регулярному выражению',
            'unique'            => 'Поле params[\'alias\'] должно быть уникальным, в БД уже есть статья с тами алиасом',
        ],

        'articleOrder' => [       // Admin/ArticleController.php
            'required'          => 'Отсутствует поле order в $request',
            'integer'           => 'Поле order в $request должно быть целочисленным значением',
            'digits_between'    => 'Поле order в $request должно быть целочисленным значением с длинной от :min до :max',
            'min'               => 'Минимальное значение поля order в $request должно быть :min',
        ],

        'articleStatus' => [     // Admin/ArticleController.php
            'required' => 'Отсутствует поле status в $request',
            'in' => 'Поле status в $request может принимать значения только 0 и 1',
        ],

        'articleText' => [       // Admin/ArticleController.php
            'required'          => 'Отсутствует поле text в $request ',
            'string'            => 'Поле text в $request должно быть строкой',
            'regex'             => 'Поле text в $request не соответствует регулярному выражению',
        ],


        'user_result_in_this_dictionary' => [       // TrainingController.php
            'required'          => 'Отсутствует поле user_result_in_this_dictionary в $request ',
            'integer'           => 'Поле user_result_in_this_dictionary в $request должно быть целочисленным значением',
            'digits_between'    => 'Поле user_result_in_this_dictionary в $request должно быть целочисленным значением с длинной от :min до :max',
            'min'               => 'Минимальное значение поля user_result_in_this_dictionary в $request должно быть :min',
        ],


        
       



        

    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],


    

    
];
