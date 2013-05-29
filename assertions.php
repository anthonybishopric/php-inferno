<?php

function assert_true($t)
{
	if ($t !== true)
	{
		throw new AssertException("$t was not true");
	}
}

function assert_that($t)
{
	return new That($t);
}

class That
{
	public function __construct($th)
	{
		$this->th = $th;
	}

	public function is_equal_to($other)
	{
		if ($this->th != $other)
		{
			throw new AssertException(inferno_sprintf("Expected %s but was %s", $other, $this->th));
		}
	}
	
	public function is_identical_to($other)
	{
		if ($this->th !== $other)
		{
			throw new AssertException(inferno_sprintf("Expected %s to be identical to %s, but it wasn't", $other, $this->th));
		}
	}
	
	public function is_instance_of($other)
	{
		if (!is_a($this->th, $other))
		{
			throw new AssertException(inferno_sprintf("Expected %s to be an instance of %s but was %s", $this->th, $other, get_class($this->th)));
		}
	}
}

class AssertException extends Exception
{
	
}

function inferno_sprintf($message/*, $arg1, $arg2 */)
{
	$args = func_get_args();
	$formatted_args = array();
	array_shift($args);
	foreach ($args as $argument)
	{
		if ($argument === null)
		{
			$formatted_args[] = '<null>';
		}
		else if ($argument === false)
		{
			$formatted_args[] = '<false>';
		}
		else if ($argument === true)
		{
			$formatted_args[] = '<true>';
		}
		else
		{
			$formatted_args[] = print_r($argument, true);
		}
	}
	array_unshift($formatted_args, $message);
	return call_user_func_array('sprintf', $formatted_args);
}