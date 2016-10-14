<?php

class Model_Main extends Model
{
	/**
	* getData($pageName)
	* Getting data for page
	* @param $pageName
	* @return $data
	*/

	public $pageDataModel;

	public function getData($pageName)
	{
		switch ($pageName) {
			case 'main_page':
				$pageDataModel['text'] = "Main page - Welcome! Hello from Model_Main =)";
				break;
			default:
				$pageDataModel['text'] = "Any page text";
				break;
		}
		return $pageDataModel;
	}
}