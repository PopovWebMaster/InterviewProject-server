<?php  
namespace App\Helpers\Contracts;

//use Illuminate\Http\Request;
//use App\User;

Interface ManipulationOfAudioFiles {
    public static function getList( $id );
    public static function delete( $id, $arr_delete_files );
    public static function rename( $id, $oldName, $newName );
    public static function upload( $id, $audioArr );
};



?>