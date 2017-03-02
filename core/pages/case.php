<?php

class Page_case extends Page
{
	function action_index($param = NULL)
	{

		return set(
			"case", 
			array(
				"{case}" => $param[0],
				"{case2}" => $param[1],
				"{btn}" => $param[2],
				"{image}" => $param[3],
				"{link}" => $param[1]

			)
		);
	}
}