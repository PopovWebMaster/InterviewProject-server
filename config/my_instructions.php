<?php  

return [
	'rules' => [
		"Одна строка - это одна пара слов 'english - русское' или 'русское - english'. Очерёдность значения не имеет",
		"В качестве разделителя можно использовать любые символы, но обязательно в этом разделителе должен присутствовать хотя-бы один пробел.",
		"В английском слове можно использовать только латинские символы. Запрещено использовать кирилицу и числа",
		"В русском слове можно использовать или только кирилические символы или только числа (для обозначения числительных)", // здесь ошибка !!!!
		"В английском слове можно использовать такие символы: ',.-!?() Все остальные символы использовать запрещено",
		"В русском слове можно использовать (если оно не числительное): !?,.-()"
	],
];



?>






