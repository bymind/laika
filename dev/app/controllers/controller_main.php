<?php

class Controller_Main extends Controller
{

	function __construct()
	{
		$this->model = new Model_Main();
		$this->view = new View();
	}
	
	public function action_index()
	{
		$pageData = $this->model->getData('main_page');
		$this->view->generate(
			'main_view.php',
			'template_view.php',
			array(
					'title'=> $pageData['title'],
					'style'=>'public/template.css',
					'style_content'=>'public/main.css',
					'active_menu' => 'menu-item-1',
					'pageId' => 'main',
					'pageData' => $pageData
				),
			'navigation_view.php',
			'footer_view.php'
			);
		return 0;
	}
}