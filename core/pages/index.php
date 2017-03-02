<?php

class Page_index extends Page
{
	function action_index($param = NULL)
	{

		return set(
			"main", 
			array(
				"{cases}" => $param[0]
			)
		);
	}
}