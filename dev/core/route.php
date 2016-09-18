<?php

	/**
	* Route
	* 
	* Класс-маршрутизатор для определения запрашиваемой страницы.
	* > цепляет классы контроллеров и моделей;
	* > создает экземпляры контролеров страниц и вызывает действия этих контроллеров.
	*/

class Route
{

	static function start()
	{
		// default action
		// $controller_name = 'Main';
		$controller_name = '';
		$action_name = 'index';
		$params = '';
		$param = '';
		// дербаним url на куски
		$routes = explode('/', $_SERVER['REQUEST_URI']);

		// первый кусок после домена - это наш контроллер
		if ( !empty($routes[1]) )
		{
			if ($routes[1][0]=="?") {
				
			} else {
				$controller_name = $routes[1];
				$controller_name = Self::PrepareUrl($controller_name);
			}
		}

		// второй кусок - это экшен
		if ( !empty($routes[2]) )
		{
			$action_name = $routes[2];
			$action_name = Self::PrepareUrl($action_name);
		}

		if ( !empty($routes[3]) )
		{
			$param= $routes[3];
			$param = Self::PrepareUrl($param);
		}

		if ( !empty($routes[4]) )
		{
			$params['name'] = $routes[3];
			$params['name'] = Self::PrepareUrl($params['name']);
			$params['target'] = $routes[4];
			$params['target'] = Self::PrepareUrl($params['target']);
		}

		// префиксы для имен
		$model_name = 'Model_'.$controller_name;
		$article_name = $controller_name;
		if ($controller_name == "") {
			$controller_name = 'Main';
		} else if ((strtolower($controller_name) == "main")&&(($action_name == "")||($action_name == "index"))) {
			route::Catch_Error('404');
		}
		$controller_name = 'Controller_'.$controller_name;
		$action_param = $action_name;
		$action_name = 'action_'.$action_name;

		// врубаем модель, если есть
		$model_file = strtolower($model_name).'.php';
		$model_path = 'application/models/'.$article_name.'/'.$model_file;
		if ( file_exists($model_path) )
		{
			include $model_path;
		}

		// та же херня с контроллером
		// плюс ищем и выполняем экшен, если он есть
		// если что-то не нашли - ебашим 404

		$controller_file = strtolower($controller_name).'.php';
		// проверим, не в админку ли хотят
		if ($controller_name == "Controller_admin") {
		// если да - лезем в папку
			$controller_path = 'application/controllers/admin/'.$controller_file;
		} else {
		// если нет - ищем в общей папке
			$controller_path = 'application/controllers/'.$controller_file;
		}
		if ( file_exists($controller_path) )
		{
			include $controller_path;

			// создаем экземпляр класса контроллера
			$controller = new $controller_name; // Controller_Main
			// создадим-ка еще одну переменную для имени экшена, старая переменная может нам еще пригодиться
			$action = $action_name; // action_index

			// проверяем наличие такого экшена в контроллере
			if ( (isset($params['target'])) && ($params['target']!=="") && ($controller_name=="Controller_admin"))
				{ // если админка
					// Route::Debug($controller_name, $action, $params);
					$controller->$action($params);
				} else
			 if (method_exists($controller, $action))
					{
						// нашли - ебашим
						if ($param==='') {
									// if ($controller_name=="Controller_admin") Route::Debug($controller_name, $action, $param);
						$controller->$action();
						} else {
						$controller->$action($param);
						}
					} else
						{ // если не нашли экшен и нет параметра, пробуем пропихнуть в основной экшен с параметром, равном имени экшена
							// if ($controller_name == "Controller_articles") {
								// если статьи - то без экшена, сразу параметр - урл статьи
								if ($param == "") {
									$param = $action_param;
									$action = 'action_index';
									// Route::Debug($controller_name, $action, $param);
									$controller->$action($param);
								} else {
									// Route::Debug($controller_name, $action, $param);
									Self::Catch_Error('404'); // не статьи - значит 404
								}
							// } else
								//{
									// Self::Catch_Error('404'); // не статьи - значит 404
									// Route::Debug($controller_name, $action, $params);
								//}
						}

		} else {
			/**
			пробуем подключить контроллер статей и показать статью
			*/
			$controller_name = "articles";
			$controller_name = "Controller_".$controller_name;
			$controller_file = strtolower($controller_name).'.php';
			$controller_path = 'application/controllers/'.$controller_file;
			include $controller_path;
			$controller = new $controller_name;
			$action = 'action_r301';
			$controller->$action($article_name);
		}
		//else Route::Catch_Error('404');

		/**
		**
		 тип отладка - функция Debug *
		*/
	}

	function PrepareUrl($u)
	{
		$u = addslashes(urldecode($u));
		//echo $u.'<br>';
		return $u;
	}

	function Catch_Error($code = null)
	{
		// Route::Debug($controller_name, $action, $params);
		// создаем контроллер ошибки
		$controller_error_name = 'controller_error_'.$code;
		$controller_error_path = 'application/controllers/errors/'.$controller_error_name.'.php';
		include $controller_error_path;

		$error_controller = new $controller_error_name;
		$error_action = 'action_index';
		$error_code = $code;

		$error_controller->$error_action($error_code);

	}

	function Catch_301_Redirect($to = "")
	{
		header('HTTP/1.1 301 Moved Permanently');
		header('Location: http://'.$_SERVER['HTTP_HOST'].$to);
		exit();
	}

	/**
	* TODO тащить список редиректов из базы через какую-нибудь модель
	* РАСШИРЯЕМОСТЬ БЛЕАТЬ!
	*/

	function RedirectList($path)
	{
		$rList = array(
			'/category/articles/' => '/articles',
			'/category/articles' => '/articles',
			'/home/статьи/' => '/articles',
			'/home/статьи' => '/articles',
			'/статьи/' => '/articles',
			'/статьи' => '/articles',
			'/upgrade_apple_macbook_pro/' => '/prices/upgrade',
			'/upgrade_apple_macbook_pro' => '/prices/upgrade',
			'/remont_apple/macbook_pro/' => '/prices/repair#mac',
			'/remont_apple/macbook_pro' => '/prices/repair#mac',
			'/remont_apple/macbook-air/' => '/prices/repair#mac',
			'/remont_apple/macbook-air' => '/prices/repair#mac',
			'/remont_apple/imac/' => '/prices/repair#mac',
			'/remont_apple/imac' => '/prices/repair#mac',
			'/remont_apple/macmini-2/' => '/prices/repair#mac',
			'/remont_apple/macmini-2' => '/prices/repair#mac',
			'/remont_apple/macpro-2/' => '/prices/repair#mac',
			'/remont_apple/macpro-2' => '/prices/repair#mac',
			'/remont_apple/macbookair/' => '/prices/repair#mac',
			'/remont_apple/macbookair' => '/prices/repair#mac',
			'/remont_apple/macbookpro/' => '/prices/repair#mac',
			'/remont_apple/macbookpro' => '/prices/repair#mac',
			'/remont_apple/ipadiphone-2/' => '/prices/repair/#iphone',
			'/remont_apple/ipadiphone-2' => '/prices/repair/#iphone',
			'/remont_apple/ipadiphone/' => '/prices/repair/#iphone',
			'/remont_apple/ipadiphone' => '/prices/repair/#iphone',
			'/remont_apple/monitor/' => '/prices/repair/#displays',
			'/remont_apple/monitor' => '/prices/repair/#displays',
			'/category/repairing' => '/prices/repair',
			'/category/repairing/' => '/prices/repair',
			'/category/stock/' => '/promo',
			'/category/stock' => '/promo',
			'/remont_apple/monitor-2/' => '/prices/repair#displays',
			'/remont_apple/monitor-2' => '/prices/repair#displays',
			'/remont_apple/hdd_repair/' => '/prices/repair#restore',
			'/remont_apple/hdd_repair' => '/prices/repair#restore',
			'/vizov_mastera/' => '/#master',
			'/vizov_mastera' => '/#master',
			'/vyzov_curiera/' => '/#curier',
			'/vyzov_curiera' => '/#curier',
		);

		$path = urldecode($path);

		if (array_key_exists($path, $rList)) {
			Self::Catch_301_Redirect($rList[$path]);
		}
		else {
		}
	}

	function Debug($controller, $action, $params)
	{
		// тип отладка
		// просто выводит имена контроллера, экшена и параметров
		echo '$controller = ';
		var_dump($controller);
		echo '<br>';
		echo '$action = ';
		var_dump($action);
		echo '<br>';
		echo '$params = ';
		var_dump($params);
		echo '<br>';
	}
}