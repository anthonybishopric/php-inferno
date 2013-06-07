<?php

// For Part I.
function try_catch_finally(callable $to_try, callable $to_catch=null, callable $and_finally=null)
{
	// implement me!
	$and_finally = $and_finally ?: function() {};
	try
	{
		$result = $to_try();
		$and_finally();
		return $result;
	}
	catch(Exception $e)
	{
		if ($to_catch)
		{
			$result = $to_catch($e);
		}
		else
		{
			$result = null;
		}
		$and_finally();
		return $result;
	}
}
