<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Projects;
use App\Dictionaries;

use Validator;
use Config;

use App\Helpers\ModelHelpers\Projects\ListProjects;


use Illuminate\Support\Facades\Storage; // ВРЕМЕННО УДАЛИТЬ !!!!!!!



use App\Helpers\SharedHelpers\ConvertorJSON;




class ProjectsController extends SiteAdminController
{
    public function __construct(){
        parent::__construct();


        // $projects = new Projects;




    }

    public function get(){

        $projects = new Projects;
        $listProjects = $projects->getListProjects();

        $this->setJson([
            'currentPage'=>'PROJECTS',
            'listProjects'=> $listProjects,
            'href_for_post' => route( 'admin_projects' ) 
        ]);

        if( view()->exists('admin.projectsAdmin') ){
            return view( 'admin.projectsAdmin', $this->data );
        };
        abort(404);

    }

    public function post( Request $request ){

        $this->connectsConstants();

        $rules = $this->getRulesValidation( $request );
        $checkArray = $this->getCheckArray( $request );

        $validator = Validator::make( $checkArray, $rules );
        if( $validator->fails() ){
            $projects = new Projects;
            $postData = [
                'listProjects' => $projects->getListProjects(),
                'href_for_post' => route( 'admin_projects' ),
                'errors' => $validator->getMessageBag()->all()
            ];
            return $postData;
        };

        if( $request->action === SET_NEW_PROJECT ){
			
            $projects = new Projects;
            $projects->setNewProject( $request->name, $this->data['userName'] );
            $postData = [
                'listProjects'=> $projects->getListProjects(),
                'href_for_post' => route( 'admin_projects' )
            ];

            return $postData;

        }else if( $request->action === DELEDE_PROJECT ){

            $projects = new Projects;
            $project = $projects->find( $request->id );
            if( !is_null($project) ){
                $projects->deleteProject( $request->id );
            };

            $postData = [
                'listProjects'=> $projects->getListProjects(),
                'href_for_post' => route( 'admin_projects' )
            ];
            return $postData;

        };

    }

    private function getRulesValidation( $request ){

        if( $request->action === SET_NEW_PROJECT ){
            $regex_projectsName = Config::get('my_config.regex.projectsName');

            return [
                'action' => 'required|string|alpha_num|in:'.SET_NEW_PROJECT.','.DELEDE_PROJECT,
                'projectsName' => 'required|string|unique:projects,name|regex:'.$regex_projectsName,
            ];
    
        }else if( $request->action === DELEDE_PROJECT ){
            return [
                'action' => 'required|string|alpha_num|in:'.SET_NEW_PROJECT.','.DELEDE_PROJECT,
                'id' => 'required|integer|digits_between:1,6|min:1',
            ];
        }else{ // окончательный else всегда лолжен быть
            return [
                'action' => 'required|string|alpha_num|in:'.SET_NEW_PROJECT.','.DELEDE_PROJECT,
            ];
        };

    }

    private function getCheckArray( $request ){

        // Данный метод создаёт массив предназначенный для использования в валидации
        // Его смысл в том, чло бы сделать из того что прийдёт в $request массим с уникальными полями, 
        // а данные уникальные поля потом можно было использовать в validation.php для создания корректных 
        // сообщений об ошибках валидации

        $checkArray = [];
        
        if( isset( $request->action ) ){
            $checkArray['action'] = $request->action;

            if( $request->action === DELEDE_PROJECT ){
                $checkArray['id'] = (int)$request->id;
            }; 
        };

        if( isset( $request->name ) ){
            $checkArray[ PROJECTS_NAME ] = $request->name;
        };

        return $checkArray;

    }

    private function connectsConstants(){

        define( 'SET_NEW_PROJECT',  'setNewProject' );
        define( 'DELEDE_PROJECT',   'deleteProject' );

        define( 'PROJECTS_NAME',    Config::get('my_config.request_nickname.projects.name') );
        
    }














}
