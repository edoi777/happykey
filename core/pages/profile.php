<?php

class Page_profile extends Page
{
	function action_index($param = NULL)
	{

		return set(
			"profile", 
			array(
				"{link}" => $param[0],
				"{name}" => $_SESSION['name'], 
				"{avatar_f}" => $param[2], 
				"{money}" => $param[1],
				"{steam}" => $_SESSION['steamid'],
				"{refid}" => 'http://'.$_SERVER['HTTP_HOST'].'?ref='.$param[4],
				"{id}" => $param[4],
				"{reflist}" => $param[5],
				"{gamesf}" => $param[6],
				"{inventory}" => $param[3]
			)
		);
	}
}