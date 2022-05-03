<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests;

use App\Http\Controllers\Controller;
use App\Projects;



class UploadAudioController extends SiteAdminController
{
    public function __construct(){
        parent::__construct();
        //$this->setJson([
        //    'currentPage'=>'PROJECT'
        //]);

    }
	
    public function post( Request $request, $id ){
		
		//print_r($request->files
		/*foreach( $request->audio as $file ){
			
			//$file = $request->file('userfile');
			$upload_folder = 'public/upload';
			$filename = $file->getClientOriginalName(); // image.jpg

			Storage::putFileAs($upload_folder, $file, $filename);
			
		};*/
		
		
		
		$upload_folder = 'audio/1'; // . - текущая папка где находится submit.php

		// cоздадим папку если её нет
		//if( ! is_dir( $upload_folder ) ) mkdir( $upload_folder, 0777 );
		
		
		foreach( $request->audio as $file ){
			$filename = $file->getClientOriginalName(); // image.jpg
			$file->move( $upload_folder, $filename );
		};
		
		
		
		/*
		
		//НЕ УДАЛЯТЬ !!!!!!!!!!!
		dump($request->audio[2]);
		$file = $request->audio[2];
		 // отображаем имя файла
		 echo 'File Name: '.$file->getClientOriginalName();
		 echo '<br>';
		 //отображаем расширение файла
		 echo 'File Extension: '.$file->getClientOriginalExtension();
		 echo '<br>';
		 //отображаем фактический путь к файлу
		 echo 'File Real Path: '.$file->getRealPath();
		 echo '<br>';
		 //отображаем размер файла
		 echo 'File Size: '.$file->getSize();
		 echo '<br>';
		 //отображаем Mime-тип файла
		 echo 'File Mime Type: '.$file->getMimeType();
		 //перемещаем загруженный файл
		 $destinationPath = 'uploads';
		 $file->move($destinationPath,$file->getClientOriginalName()); // рабочий только этот!!!!!!!!!!!!1
		 
		 //Storage::putFile('avatars', $file);
		 //Storage::putFileAs($destinationPath, $file->getClientOriginalName());
		 
		//$file2 = $request->audio[2];
        //$upload_folder = 'public/folder';
        //$filename = $file2->getClientOriginalName(); // image.jpg

        //Storage::putFileAs($upload_folder, $file2, $filename);
		
		//НЕ УДАЛЯТЬ (конец) !!!!!!!!!!!
		*/
			
		return 'Ура! Успех '.$request->action;
			
			
			
			
			
			
			
			
			
			
			
			
		
		
		/*
		$PROJECT = new Projects;
        $project = $PROJECT->find( $id );

        if( $project === null ){
            return redirect()->route('admin_projects');
        };

		$name = $request->file('audio')->store('upload', 'public');

        $this->setJson([
            'currentPage'=>'PROJECT',
            'name' => $project->name,
            'description' => $project->description,
            'words' => $PROJECT->getListWordsFromClient( $id ), // $responseArr
            'created_at' => $project->created_at,
            'status' => $project->status,
            'author' => $project->author,
            'href_for_post' => route( 'admin_project', [ 'id' => $id ] ),
			'audio' => $name
        ]);

        $this->data['name'] = $project->name;
		
		
		
		
		

        if( view()->exists('admin.projectAdmin') ){
            return view( 'admin.projectAdmin', $this->data );
        };
        abort(404);
		*/
		
    }
}
