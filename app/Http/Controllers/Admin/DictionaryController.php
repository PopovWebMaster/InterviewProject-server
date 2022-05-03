<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Dictionaries;
use App\Projects;
use Config;
use Validator;

class DictionaryController extends SiteAdminController
{
    
    public function __construct(){
        parent::__construct();
    }

    public function get( $id ){

        $dic = new Dictionaries;
        $dictionary = $dic->find( (int)$id );
		if( is_null( $dictionary ) ){
			return redirect()->route('home' );
		};

        $projectName = null;
        $projectId = null;
        $href_project = null;
        $words = null;

        // Если к данному словарю уже привязан свой проект
        if( !is_null( $dictionary->projects_id ) ){
            if( is_numeric( $dictionary->projects_id ) ){
                $proj = new Projects;
                $project = $proj->find( $dictionary->projects_id );
                $projectName = $project->name;
                $projectId = $project->id;
                $href_project = route( 'admin_project', $project->id );
                $words = $proj->getListWordsFromDictionary( $projectId );
            };
        };

        // Получает массив проектов не привязанных ни к одному словарю (свободных проектов)
        $arrListFreeProjects = [];
        $involvedProjects = $dic->where('projects_id','>=', '0' )->get();
        $involvedIdProjects = [];
        foreach( $involvedProjects as $obj ){
            $involvedIdProjects[$obj->projects_id] = true;
        };
        $proj = new Projects;
        $proj = $proj->get();
        foreach( $proj as $obj ){
            if( !isset( $involvedIdProjects[ $obj->id ] ) ){
                $resObj = [
                    'id'=> $obj->id,
                    'name' => $obj->name
                ];
                array_push( $arrListFreeProjects, $resObj );
            };
        };

        // Получает массив имён сущетвующих словарей
        $arrListNamesDictionaries = [];
        $dicArr = $dic->get();
        foreach( $dicArr as $obj ){
            array_push( $arrListNamesDictionaries, $obj->name );
        };

        $this->setJson([
            'currentPage' => 'DICTIONARY',
            'id' => $id,
            'name' => $dictionary->name,
            'queue' => $dictionary->queue,
            'status' => $dictionary->status,
            'projectName' => $projectName,
            'projectId' => $projectId,
            'arrListFreeProjects' => $arrListFreeProjects,
            'href_project' => $href_project,
            'arrListQueue' => $dic->getArrListQueue(), // $arrListQueue
            'arrListNamesDictionaries' => $arrListNamesDictionaries,
            'words' => $words,
            'href_for_post' => route( 'admin_dictionary', $id ),

        ]);

        $this->data['dictionaryName'] = $dictionary->name;

        if( view()->exists('admin.dictionaryAdmin') ){
            return view( 'admin.dictionaryAdmin', $this->data );
        };
        abort(404);
    }


    public function post( Request $request,  $id ){

        //  Данный метод post() расчитывает на то, что после отправки данных клиенту, клиент перезагрузит страницу
        // по указанному в [ 'href' => 'http//:...' ] адресу
        
        // Варианты
        // action:  'setNewParamsOneDictionary', 
        // 		    'deleteDictionary'

        // params: [ // Все поля данного массива должны присутствовать обязательно, все 5 штук иначе - ошибка
        //     'name' => 'Имя словаря',
        //         // Должен содержать только строку, не пустую
        //     'status' => true/false,
        //         // Должен содержать только boolean значение
        //     'queue' => 0
        //         // Должен содержать только 0 или целое, положительное число,
        //         //   0 - значит поставить в конец очереди, в таком случает queueAction игнорируется
        //         //   число - поставить на позицию указанную в queueAction
        //     'queueAction' => false/'insert'/'replace',
        //         // Это команда, что делать с новой очередью
        //         //   false - ничего не делать
        //         //   'insert' - вставить на место queue со смещением очереди вниз
        //         //   'replace' - поменять местами, вставив на новое место queue
        //     'projectId' => 0,
        //         // Должен содержать только 0 или целое, положительное число,
        //         //   0 - значит отвязать существующий проект
        //         //   число - привязать новый проект с указанным id
        // ]
        	
        $this->connectsConstants(); 
        $rules = $this->getRulesValidation( $request );
        $checkArray = $this->getCheckArray( $request, $id );

        $validator = Validator::make( $checkArray, $rules );
        if( $validator->fails() ){
            return [
                'ok' => false, 
                'comment' => 'Проверка НЕ прошла',
                'req' => $request->params,
                'checkArray' => $checkArray,
                'massage' => $validator->getMessageBag()->all()
            ];
        };

        $dictionary = new Dictionaries;

        $ok;
        $href = route('admin_dictionary', $id );
        $res = false;

		if( $request->action === SET_NEW_PARAMS_ONE_DICTIONARY ){

            $res = $dictionary->setNewParams( $id, $request->params ); 
            $ok = $res['ok'];
            
		}else if( $request->action === DELEDE_DICTIONARY ){

            $res = $dictionary->deleteDictionary( $id );
            $ok = $res['ok'];
            
        };

        return [
            'ok' => $ok,
            'href' => $href,
            'res' => $res
        ];
          
    }

    private function getRulesValidation( $request ){

        $regex_dictionaryName = Config::get('my_config.regex.dictionaryName');

        $rules = [];
        $rules['action'] =  'required|string|alpha_num|in:'.SET_NEW_PARAMS_ONE_DICTIONARY.','.DELEDE_DICTIONARY;
        $rules['id'] =      'required|integer|digits_between:1,6|min:1';

        if( $request->action === SET_NEW_PARAMS_ONE_DICTIONARY ){

            $require_with_name =            'required_with:'.STATUS.','.QUEUE.','.QUEUE_ACTION.','.PROJECT_ID;
            $require_with_status =          'required_with:'.NAME.','.QUEUE.','.QUEUE_ACTION.','.PROJECT_ID;
            $require_with_queue =           'required_with:'.NAME.','.STATUS.','.QUEUE_ACTION.','.PROJECT_ID;
            $require_with_queue_action =    'required_with:'.NAME.','.STATUS.','.QUEUE.','.PROJECT_ID;
            $require_with_project_id =      'required_with:'.NAME.','.STATUS.','.QUEUE.','.QUEUE_ACTION;

            $rules[ NAME ] =            $require_with_name.'|string|regex:'.$regex_dictionaryName;
            $rules[ STATUS ] =          $require_with_status.'|in:true,false';
            $rules[ QUEUE ] =           $require_with_queue.'|integer|digits_between:1,6|min:0';
            $rules[ QUEUE_ACTION ] =    $require_with_queue_action.'|in:false,insert,replace';
            $rules[ PROJECT_ID ] =      $require_with_project_id.'|integer|digits_between:1,6|min:0';

        }/*else if( $request->action === DELEDE_DICTIONARY ){
            
        }*/;

        return $rules;
  
    }

    private function getCheckArray( $request, $id ){

        // Данный метод создаёт массив предназначенный для использования в валидации
        // Его смысл в том, что бы сделать из того что прийдёт в $request, массив с уникальными полями, 
        // а данные уникальные поля уже потом можно было использовать в validation.php для создания корректных, уникальных
        // сообщений об ошибках валидации

        $checkArray = [];
        $checkArray['id'] = (int)$id;

        if( isset( $request->action ) ){
           $checkArray['action'] = $request->action;
        };

        if( isset( $request->params['name'] ) ){
            $checkArray[ NAME ] = $request->params['name'];
        };

        if( isset( $request->params['status'] ) ){
            $checkArray[ STATUS ] = $request->params['status'];
        };

        if( isset($request->params['queue']) ){
            $checkArray[ QUEUE ] = $request->params['queue'];
        };

        if( isset($request->params['queueAction']) ){
            $checkArray[ QUEUE_ACTION ] = $request->params['queueAction'];
        };

        if( isset($request->params['projectId']) ){
            $checkArray[ PROJECT_ID ] = (int)$request->params['projectId'];
        };

        return $checkArray;

    }

    private function connectsConstants(){

        define( 'SET_NEW_PARAMS_ONE_DICTIONARY',    'setNewParamsOneDictionary' );
        define( 'DELEDE_DICTIONARY',                'deleteDictionary' );

        define( 'NAME',          Config::get('my_config.request_nickname.dictionary.name') );
        define( 'STATUS',        Config::get('my_config.request_nickname.dictionary.status') );
        define( 'QUEUE',         Config::get('my_config.request_nickname.dictionary.queue') );
        define( 'QUEUE_ACTION',  Config::get('my_config.request_nickname.dictionary.queueAction') );
        define( 'PROJECT_ID',    Config::get('my_config.request_nickname.dictionary.projectId') );


        // define( 'DICTIONARY_NAME',          Config::get('my_config.request_nickname.dictionary.name') );
        // define( 'DICTIONARY_STATUS',        Config::get('my_config.request_nickname.dictionary.status') );
        // define( 'DICTIONARY_QUEUE',         Config::get('my_config.request_nickname.dictionary.queue') );
        // define( 'DICTIONARY_QUEUE_ACTION',  Config::get('my_config.request_nickname.dictionary.queueAction') );
        // define( 'DICTIONARY_PROJECT_ID',    Config::get('my_config.request_nickname.dictionary.projectId') );

    }






}















































