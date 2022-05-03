<?php

namespace App\Helpers\ModelHelpers\Dictionaries;

use App\Dictionaries;
use App\Projects;

class SetNewParams {

    protected $errors = [];
    protected $isError = false;

    protected $id;

    protected $name; 
    protected $status; 
    protected $queue; 
    protected $queueAction; 
    protected $projectId; 

    protected $dictionary;
    protected $dictionaries;

    protected $vrem;

    public function __construct( $id = null, $params = null ){
        $this->id = $id;
        $this->sortsFields( $params ); 
    }

    private function setError( $str ){
        array_push( $this->errors, $str );
        $this->isError = true;
    }

    private function sortsFields( $params ){

        $this->addName( $params );
        $this->addStatus( $params );
        $this->addQueue( $params );
        $this->addQueueAction( $params );
        $this->addProjectId( $params );

    }

    private function addName( $params ){

        $dictionaries = new Dictionaries();
        $dic = $dictionaries->where('name', '=', $params[ 'name' ] )->first();

        if( is_null($dic) ){
            $this->name = $params[ 'name' ];
        }else{
            if( (int)$dic->id === (int)$this->id ){
                $this->name = $params[ 'name' ];
            }else{
                $str = 'Значение поля name не уникально, в БД уже есть name с таким именем';
                $this->setError( $str );
            };
        }; 

    }

    private function addStatus( $params ){

        if( $params['status'] === 'true' ){
            $this->status = true;
        }else if( $params['status'] === 'false' ){
            $this->status = false;
        }else{
            $this->status = $params['status'];
        };
        
    }

    private function addQueue( $params ){
        $this->queue = (int)$params['queue'];
    }

    private function addQueueAction( $params ){

        if( $params['queueAction'] === 'false' ){
            $this->queueAction = false;
        }else{
            $this->queueAction = $params['queueAction'];
        };

    }

    private function addProjectId( $params ){

        $dictionaries = new Dictionaries();
        $dic = $dictionaries->where('projects_id', '=', (int)$params['projectId'] )->first();

        if( is_null($dic) ){
            $this->projectId = (int)$params['projectId'];
        }else{
            if( (int)$dic->id === (int)$this->id ){
                $this->projectId = (int)$params['projectId'];
            }else{
                $str = 'Значение поля projectId не уникально. В БД уже существует projectId с таким именем';
                $this->setError( $str );
            };
        };  
    }
    
    private function setName(){

        $dictionaries = new Dictionaries();
        $dic = $dictionaries->find( $this->id );
        $dic->name = $this->name;
        $dic->save();
        
    }

    private function setStatus(){

        $dictionaries = new Dictionaries();
        $dic = $dictionaries->find( $this->id );

        if( $this->projectId === 0 ){
            $dic->status = false;
        }else{
            $dic->status = $this->status;
        };

        $dic->save();

    }

    private function setQueue(){

        $dictionaries = new Dictionaries();
        $dic = $dictionaries->find( $this->id );

        if( $dic->status ){
            
            if( $this->queue === 0 ){ // нужно поставить последним в очереди
                $dic->setNewQueue('insertToEnd', [ 'idDictionary'=> $this->id ]);
            }else{

                if( $this->queueAction !== false ){ // false значит ничего не делать

                    $current_queue;
                    if( is_null( $dic->queue ) ){
                        $lastQueue = $dic->setNewQueue('insertToEnd', [ 'idDictionary'=> $this->id ]);
                        $current_queue = $lastQueue['newQueue'];
                    }else{
                        $current_queue = (int)$dic->queue;
                    };
    
                    $next_queue;
                    if( $this->queue  === 0 ){ // пришло от клиента,(status = true) означает поставить последним в очереди
                        $next_queue = $dic->getLastQueue();
                    }else{
                        $next_queue = $this->queue;
                    };

                    $dic->setNewQueue( $this->queueAction, [ 
                        'idDictionary'=> $this->id,
                        'currentQueue' => $current_queue,
                        'nextQueue' => $next_queue
                    ]);
                    
                };

            };

        }else{
            $dic->setNewQueue('deleteQueue', [ 'idDictionary'=> $this->id ]);
        };

    }

    private function setProjectId(){

        $dictionaries = new Dictionaries();
        $dic = $dictionaries->find( $this->id );

        if( $this->projectId === 0 ){
            $dic->projects_id = null;
        }else{
            $dic->projects_id = $this->projectId;
        };
        $dic->save();
    }

    public function make(){

        if( !$this->isError ){
            $this->setName();
            $this->setStatus();
            $this->setQueue();
            $this->setProjectId();
        };

    }

    public function getErrors(){
        return $this->errors;
    }

    public function isSaccess(){
        return !$this->isError;
    }

   

};


?>
