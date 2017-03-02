<?php

class Page_list extends Page
{
	function action_index($param = NULL)
	{

		return set(
			"list", 
			array(
				"{list}" => $param[0]

			)
		);
	}
}