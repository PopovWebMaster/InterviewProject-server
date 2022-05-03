<?php  
namespace App\Http\Controllers\Auth\AuthTraits\TestsTraits;

// $HR = '-----------------------------------------------------';

trait TestResetPasswordTrait {

    // $this->HR = '-----------------------------------------------------';

    // public function __construct(){
        
    // }

    use TEST_check_one_field_reset_password;
    use TEST_to_determine_the_current_stage_of_the_password_reset;

    protected function RUN_TESTS_PasswordResetTrait(){

        $this->hr = '-----------------------------------------------------';

        // $this->TEST_check_one_field_reset_password();
        $this->TEST_to_determine_the_current_stage_of_the_password_reset();



        dump($this->hr);
        dd('КОНЕЦ');
    }


    

};

?>
