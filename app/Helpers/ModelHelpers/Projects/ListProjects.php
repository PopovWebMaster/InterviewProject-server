<?php

namespace App\Helpers\ModelHelpers\Projects;
use App\Dictionaries;
use App\Projects;

class ListProjects{

    //function __construct( $params ){}

    static public function get(){

        $projects = Projects::get();
        $listProjects = [];

        foreach( $projects as $k ){
            $id = $k->id;
            
            $dic = new Dictionaries;
            $dictionary = $dic->where('projects_id','=', $id )->first();
            $status = 0;
            if( !is_null( $dictionary ) ){
                $status = $dictionary->status;  
            };
            $obj = [
                'name' => $k->name,
                'author' => $k->author,
                'date' => $k->created_at,
                'id_project' => $k->id,
                'status' => $status,
                'href' => route( 'admin_project', [ 'id' => $k->id ] )
            ];
            array_push($listProjects, $obj);
        };

        return $listProjects;

    }

};




?>