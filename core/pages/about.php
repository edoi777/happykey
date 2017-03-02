<?php

class Page_about extends Page
{
	function action_index($param = NULL)
	{

		return set(
			"about", 
			array(
				'{32}' => NULL
			)
		);
	}
}