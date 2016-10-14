<?php

	/**
	* View
	* 
	* Родительский класс представлений
	*/

class View
{
	/*
	function generate(string, string [, array]) - создает отображение страницы
	$content_view - отображение контент страницы;
	$template_view - общий шаблон для всех страниц;
	$data - массив данных; <- TO DO IN MODEL!
	*/
	
	/**
	* generate
	* 
	* @param string $content_view строка
	* @param string $template_view строка
	* @param array $data массив данных
	* @param string $navigation_view строка
	* @param string $footer_view строка
	* @param string $modals_view строка
	* @return 0
	*/
	function generate($content_view, $template_view, $data = null, $navigation_view = 'navigation_view.php', $footer_view = 'footer_view.php', $modals_view = 'modals_view.php' )
	{

		$OgType = 'website';
		$OgImage = '/img/public/laika-og.png';

		// файл с настройками favicon и других иконок
		$Favicon = 'app/views/favicons.php';

		if (is_array($data))
		{
			extract($data);
		}

		$Navigation = 'app/views/'.$navigation_view;

		$Footer = 'app/views/'.$footer_view;

		$Content = 'app/views/'.$content_view;

		if (is_array($modals_view)) {
			extract($modals_view);
			foreach ($modals_view as $modals) {
				$mod = 'app/views/'.$modals;
				include $mod;
			}
		} else
		$Modals = 'app/views/'.$modals_view;


		// переименовываем с большой буквы для красивого шаблона
		$Title = $title;

		// переименовываем с большой буквы... короче, то же самое
		$Style = $style;
		$Style_content = $style_content;

		// подключаем общий шаблон, внутри которго встроятся шаблон страницы и данные из $data
		include 'app/views/'.$template_view;

		return 0;

		exit();
	}

	function simpleGet($content_view, $data = null)
	{
		if (is_array($data))
		{
			extract($data);
		}

		include 'app/views/'.$content_view;

		exit();
	}
}