<?php

	/**
	* Controller
	* 
	* Родительский класс контролллеров
	*/

class Controller
{
	public $model; // свойство для общения с моделью
	public $view; // свойство для общения с представлением

	/**
	* __construct
	* 
	* конструктор, в котором создаем привязку к модели и представлениям
	* 
	* @return 0
	*/

	function __construct()
	{
		$this->is_logged();
		$this->view = new View();
		$this->model = new Model();
	}

	/**
	* is_logged
	* 
	* проверяет, залогинен ли посетитель
	* 
	* @return bool
	*/

	function is_logged()
	{
		if (isset($_SESSION['id']))
		{
			return true;
		} else
		{
			return false;
		}
	}

	/**
	* backDay
	* 
	* меняет время на "вчера" или "сегодня", если возможно
	* 
	* @param string $timeStamp метка времени
	* @param string $postDay день поста
	* @return string $postDay
	*/

	function backDay($timeStamp, $postDay)
	{
		$nowDay = (int)date('d');
		$nowUnix = (int)date('U');
		$delta = $nowUnix - $timeStamp;

		if ($delta < (60*60*24)) {
			if ( $nowDay == ($postDay + 1) ) {
				return 'вчера';
			}
			if ( $nowDay == $postDay ) {
				return 'сегодня';
			}
		} else
			return $postDay;
	}

	/**
	* getGoodDate
	* 
	* меняет метку времения на "вчера" или "сегодня", или на дату
	* 
	* @param string $timeStamp метка времени
	* @param string $format формат (default | compact)
	* @return string $newTimeStamp
	*/

	function getGoodDate($timeStamp, $format = 'default')
	{
		$xdate = explode(' ', $timeStamp);
		$xday = $xdate[0];
		$xtime = $xdate[1];
		$xday = explode("-", $xday);
		$xyear = (int) $xday[0];
		$xm = (int) $xday[1];
		$xday = (int) $xday[2];
		$xmonth = array ('','января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря');
		$xmonth = $xmonth[$xm];
		$xtime = explode(':', $xtime);
		$xh = $xtime[0];
		$xmin = $xtime[1];
		$xs = $xtime[2];
		$xtimeunix =  mktime($xh, $xmin, $xs, $xm, $xday, $xyear);

			if ($format == "default") {
				$xday = (self::backDay($xtimeunix, $xday)=='сегодня')||(self::backDay($xtimeunix, $xday)=='вчера') ? $newTimeStamp = self::backDay($xtimeunix, $xday).' в '.$xh.':'.$xmin : $newTimeStamp = $xday.' '.$xmonth.' '.$xyear.' в '.$xh.':'.$xmin;
			}
			if ($format == 'compact') {
				$xday = (self::backDay($xtimeunix, $xday)=='сегодня')||(self::backDay($xtimeunix, $xday)=='вчера') ? $newTimeStamp = self::backDay($xtimeunix, $xday) : $newTimeStamp = $xday.' '.$xmonth.' '.$xyear;
			}

		return $newTimeStamp;
	}


	/**
	* goLogin
	* 
	* процедура входа
	* 
	* @param string $redirect редирект после логина
	* @return bool
	*/

	function goLogin($redirect = "/admin")
	{
		$errors = array();

		if ( empty($_POST['login']) || empty($_POST['passw']) )
		{
			$errors[] = 'Ну-ну';
		} else
			{
				$login =  substr(htmlspecialchars(trim($_POST['login'])), 0, 60);
				$password = md5($_POST['passw']);

				$ds = Model::get_login($login);

				if($login == $ds['login'] && $password == $ds['passw']){
					$_SESSION['id'] = $ds['id'];
					$_SESSION['name'] = $ds['login'];
					$_SESSION['is_su'] = $ds['is_super'];
					$_SESSION['telegram_token'] = $ds['telegram_token'];
					$_SESSION['telegram_id'] = $ds['telegram_id'];
					$salt = 'dsflFWR9u2xQa';
					$_SESSION['access_key'] = md5($ds['login'].$ds['passw'].$salt);
					setcookie("id",$_SESSION['id'], time()+60*60*24*30);
					// var_dump($redirect);
					// header('location:'.$redirect);
					echo "<script>location.reload();</script>";
					return true;
				}
				else
				{
					$errors[] = "Неверные данные";
				}
			}

			if ( $errors ) {
				# show errors
				foreach ($errors as $error) {
					echo $error."<br>";
				}
				return false;
			}
	}

	/**
	* logout
	* 
	* разлогинивание
	* 
	* @return 0
	*/

	function logout()
	{
		setcookie("id","");
		unset($_SESSION['id']);
		header('Location:/admin');
		return 0;
	}
}