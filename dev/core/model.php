<?php

class Model
{
	public function get_data()
	{
		
	}

	public function get_login($login)
	{
		$select = mysql_query("SELECT * FROM users WHERE login = '$login'")or die(mysql_error());
		
		$ds = mysql_fetch_assoc($select);

		return $ds;
	}
}