<?php

class Page_support extends Page
{
	function action_index($param = NULL)
	{

		return set(
			"support", 
			array(
				'{32}' => NULL
			)
		);
	}
}