<?php

class Model_Main extends Model
{
	/**
	* getData($pageName)
	* Getting data for page
	* @param $pageName
	* @return $data
	*/
	public function getData($pageName)
	{
		switch ($pageName) {
			case 'main_page':
				$data['text'] = "Main page - Welcome! Hello from Model_Main =)";
				break;
			default:
				$data['text'] = "Any page text";
				break;
		}
		return $data;
	}
}