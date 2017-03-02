<?php

class Page_manual extends Page
{
	function action_index($param = NULL)
	{

		return set(
			"manual", 
			array(
				'{32}' => NULL
			)
		);
	}
}