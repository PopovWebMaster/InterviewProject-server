<?php  
namespace App\Http\Controllers\Auth\AuthTraits\TestsTraits;

// $HR = '-----------------------------------------------------';

trait TEST_check_one_field_reset_password {

    protected function TEST_check_one_field_reset_password(){

        dump( 'function: $this->check_one_field_reset_password()' );
        dump($this->hr);
        // EMAIL   
        // SECRET_CODE 
        // PASSWORD 
        // PASSWORD_CONFIRMATION

        $test_params_EMAIL = [
            [ // 0
                'inputName' => EMAIL,
                'value' => 'daaad@mail.ru', // нет в БД
                'comment' => '',
            ],
            [ // 1
                'inputName' => EMAIL,
                'value' => 'dubq@mail.ru', // есть в БД
                'comment' => '',
            ],
            [ // 2
                'inputName'=> EMAIL,
                'value' => 'qwqwqw',
                'comment' => '',
            ],
            [ // 3
                'inputName' => EMAIL,
                'value' => '!#$!$',
                'comment' => '',
            ],
            [ // 4
                'inputName' => EMAIL,
                'value' => '',
                'comment' => '',
            ],
            [ // 5
                'inputName' => EMAIL,
                'value' => null,
                'comment' => 'В значении null',
            ],
            [ // 6
                'inputName' => EMAIL,
                'value' => false,
                'comment' => '',
            ],
            [ // 7
                'inputName' => EMAIL,
                'value' => true,
                'comment' => '',
            ],
        ];


        $test_params_SECRET_CODE = [
            [ // 0
                'inputName' => SECRET_CODE,
                'value' => 'assas21ew43t', // нет в БД
                'comment' => 'Нормальный',
            ],
            [ // 1
                'inputName' => SECRET_CODE,
                'value' => 'assas21ew', // есть в БД
                'comment' => 'норм, но мало знаков',
            ],
            [ // 2
                'inputName'=> SECRET_CODE,
                'value' => 'assas21ew43t323232',
                'comment' => 'норм, но много знаков',
            ],
            [ // 3
                'inputName' => SECRET_CODE,
                'value' => '',
                'comment' => 'пустая строка',
            ],
            [ // 4
                'inputName' => SECRET_CODE,
                'value' => false,
                'comment' => 'false',
            ],
            [ // 5
                'inputName' => SECRET_CODE,
                'value' => null,
                'comment' => 'В значении null',
            ],
            [ // 6
                'inputName' => SECRET_CODE,
                'value' => true,
                'comment' => 'true',
            ],
            [ // 7
                'inputName' => SECRET_CODE,
                'value' => 'assas2+ew43t',
                'comment' => '',
            ],
        ];

        $test_params_PASSWORD = [
            [ // 0
                'inputName' => PASSWORD,
                'value' => 'assas21ew43t', // нет в БД
                'comment' => '',
            ],
            [ // 1
                'inputName' => PASSWORD,
                'value' => 'assas№"!;21ew', // есть в БД
                'comment' => '',
            ],
            [ // 2
                'inputName'=> PASSWORD,
                'value' => '213',
                'comment' => 'мало символов',
            ],
            [ // 3
                'inputName' => PASSWORD,
                'value' => 'укеукеуеукеапвпаsfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsddsfsddsdfsdsdfdsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsfd',
                'comment' => 'много символов',
            ],
            [ // 4
                'inputName' => PASSWORD,
                'value' => false,
                'comment' => 'false',
            ],
            [ // 5
                'inputName' => PASSWORD,
                'value' => null,
                'comment' => 'В значении null',
            ],
            [ // 6
                'inputName' => PASSWORD,
                'value' => true,
                'comment' => 'true',
            ],
            [ // 7
                'inputName' => PASSWORD,
                'value' => '',
                'comment' => '',
            ],
        ];

        $test_params_PASSWORD_CONFIRMATION = [
            [ // 0
                'inputName' => PASSWORD_CONFIRMATION,
                'value' => 'assas21ew43t', // нет в БД
                'comment' => '',
            ],
            [ // 1
                'inputName' => PASSWORD_CONFIRMATION,
                'value' => 'assas№"!;21ew', // есть в БД
                'comment' => '',
            ],
            [ // 2
                'inputName'=> PASSWORD_CONFIRMATION,
                'value' => '213',
                'comment' => 'мало символов',
            ],
            [ // 3
                'inputName' => PASSWORD_CONFIRMATION,
                'value' => 'укеукеуеукеапвпаsfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsddsfsddsdfsdsdfdsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsfd',
                'comment' => 'много символов',
            ],
            [ // 4
                'inputName' => PASSWORD_CONFIRMATION,
                'value' => false,
                'comment' => 'false',
            ],
            [ // 5
                'inputName' => PASSWORD_CONFIRMATION,
                'value' => null,
                'comment' => 'В значении null',
            ],
            [ // 6
                'inputName' => PASSWORD_CONFIRMATION,
                'value' => true,
                'comment' => 'true',
            ],
            [ // 7
                'inputName' => PASSWORD_CONFIRMATION,
                'value' => '',
                'comment' => '',
            ],
        ];


        $this->runTest( $test_params_EMAIL );
        $this->runTest( $test_params_SECRET_CODE );
        $this->runTest( $test_params_PASSWORD );
        $this->runTest( $test_params_PASSWORD_CONFIRMATION );

        

    }


    private function runTest( $testParams ){

        for( $i = 0; $i < count( $testParams ); $i++){

            $res = $this->check_one_field_reset_password( $testParams[$i] );
            dump( 'номер поля '.$i );
            dump( $testParams[$i]['inputName'].' - '.$testParams[$i]['value'] );
            dump( $res );

            if( $testParams[$i]['comment'] !== '' ){
                dump( 'Комментарий: '.$testParams[$i]['comment'] );
            };
            
            dump( $this->hr );
        };
    }
};

?>

