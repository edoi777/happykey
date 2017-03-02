<?php

class Page_user extends Page
{
	function action_index($param = NULL)
	{

		return set(
			"user", 
			array(
				"{ava}" => $param[0],
				"{inv}" => $param[2],
				"{level}" => $param[3],
				"{name}" => $param[4],
				"{op}" => $param[5],
				"{link}" => $param[1]

			)
		);
	}
}