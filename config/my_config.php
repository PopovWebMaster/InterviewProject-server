<?php  

return [
	'regex' => [
		'enW' 				=> '/^[_a-zA-Z \.\-\+\?,:;_!()\']+$/',
        'ruW' 				=> '/^[_0-9абвгдеёжзийклмнопрстуфхцчшщъыьэюяАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯ \.\-\+\?,:;_!()]+$/',
		'newDescription' 	=> '/^[_a-zA-Z0-9абвгдеёжзийклмнопрстуфхцчшщъыьэюяАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯ ()\.\-\+\?,:;_!]+$/',
		'dictionaryName' 	=> '/^[0-9a-zA-ZабвгдеёжзийклмнопрстуфхцчшщъыьэюяАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯ \.\-\?\',:;!]{1,250}$/',
		'projectsName'		=> '/^[0-9a-zA-ZабвгдеёжзийклмнопрстуфхцчшщъыьэюяАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯ \.\-\?\',:;!]{1,250}$/',
		'settings_str'		=> '/^[0-9a-zA-ZабвгдеёжзийклмнопрстуфхцчшщъыьэюяАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯ \.\-\?\',:;!]+$/',
		'alias'				=> '/^[0-9a-zA-Z\-_]{1,150}$/',

		'articleText'		=> '/^[0-9a-zA-ZабвгдеёжзийклмнопрстуфхцчшщъыьэюяАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯ \.\-\?\',:;!=\+@#\$%&\*\(\)"]+$/',

		'user_name'			=> '/^[0-9a-zA-ZабвгдеёжзийклмнопрстуфхцчшщъыьэюяАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯ \-_\']{1,255}$/',
		
	],

	'request_nickname' => [

		'dictionaries' =>[
			'name' => 'dictionariesName',
		],

		'dictionary' => [
			'name' => 			'dictionaryName',
			'status' => 		'dictionaryStatus',
			'queue' => 			'dictionaryQueue',
			'queueAction' => 	'dictionaryQueueAction',
			'projectId' => 		'dictionaryProjectId',
		],

		'project' => [
			'newDescription' => 'projectNewDescription',
			'words' => 			'projectWords',
			'deletedArr' => 	'projectDeletedArr',
		],

		'projects' => [
			'name' => 			'projectsName',
		],

		'analysis' => [
			'wordsForCheck' => 	'analysisWordsForCheck',
			'idProject' => 		'analysisIdProject',
			'words' => 			'analysisWords',
		],

		'settings' => [
			'paramsNum'	=>		'settingsParamsNum',
			'paramsStr'	=>		'settingsParamsStr',
			'paramsRadio'	=>	'settingsParamsRadio',
			'paramsCheckbox' =>	'settingsParamsCheckbox',
		],

		'article' => [
			'title' => 			'articleTitle',
			'second_title' => 	'articleSecond_title',
			'alias' => 			'articleAlias',
			'order' => 			'articleOrder',
			'status' => 		'articleStatus',
			'text' => 			'articleText',
		],







		

	],


];



?>