<?php  
namespace App\Http\Controllers\Auth\AuthTraits\TestsTraits;

// $HR = '-----------------------------------------------------';

trait TEST_to_determine_the_current_stage_of_the_password_reset {

    protected function TEST_to_determine_the_current_stage_of_the_password_reset(){

        dump( 'function: $this->TEST_to_determine_the_current_stage_of_the_password_reset()' );
        dump($this->hr);
       

        $testParams = [
            [
                'email' =>                  'dubq@mail.ru',
                'password' =>               '',
                'password_confirmation' =>  '',
                'secret_code' =>            '',

                'comment' => '',
            ],
            [
                'email' =>                  '',
                'password' =>               '111111',
                'password_confirmation' =>  '111111',
                'secret_code' =>            '',

                'comment' => '',
            ],
            [
                'email' =>                  '',
                'password' =>               '',
                'password_confirmation' =>  '',
                'secret_code' =>            'qweqweqwe',

                'comment' => '',
            ],
            [
                'email' =>                  'dubq@mail.ru',
                'password' =>               '',
                'password_confirmation' =>  '',
                'secret_code' =>            'sdsdfsdf',

                'comment' => '',
            ],
            [
                'email' =>                  '',
                'password' =>               '111111',
                'password_confirmation' =>  '',
                'secret_code' =>            '',

                'comment' => '',
            ],
            [
                'email' =>                  '',
                'password' =>               '1111111',
                'password_confirmation' =>  '1111111',
                'secret_code' =>            'rewrw',

                'comment' => '',
            ],
            [
                'email' =>                  '',
                'password' =>               '',
                'password_confirmation' =>  '1111111',
                'secret_code' =>            '',

                'comment' => '',
            ],
            [
                'email' =>                  '',
                'password' =>               '',
                'password_confirmation' =>  '1111111',
                'secret_code' =>            'rewrw',

                'comment' => '',
            ],
            [
                'email' =>                  'ddw@weerw.df',
                'password' =>               '',
                'password_confirmation' =>  '',
                'secret_code' =>            'rewrw',

                'comment' => '',
            ],

            [
                // 'email' =>                  '',
                'password' =>               '',
                'password_confirmation' =>  '',
                'secret_code' =>            'rewrw',

                'comment' => '',
            ],
            [
                // 'email' =>                  '',
                'password' =>               '',
                'password_confirmation' =>  '',
                // 'secret_code' =>            'rewrw',

                'comment' => '',
            ],
            [
                // 'email' =>                  '',
                // 'password' =>               '',
                // 'password_confirmation' =>  '',
                // 'secret_code' =>            'rewrw',

                'comment' => '',
            ],
        ];


        $this->runTest2( $testParams );

        

    }


    private function runTest2( $testParams ){

        for( $i = 0; $i < count( $testParams ); $i++){

            $res = $this->to_determine_the_current_stage_of_the_password_reset( $testParams[$i] );
            dump( 'номер поля '.$i );
            dump( $testParams[$i] );

            dump( 'stage '.$res );
            dump( $res );

            // if( $testParams[$i]['comment'] !== '' ){
            //     dump( 'Комментарий: '.$testParams[$i]['comment'] );
            // };
            
            dump( $this->hr );
        };
    }
};

?>

