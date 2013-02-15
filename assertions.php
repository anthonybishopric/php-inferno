<?php

function assert_true($t)
{
	if ($t !== true)
	{
		throw new Exception("$t was not true");
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
			throw new Exception("Expected $other but was " . $this->th);
		}
	}
	
	public function is_instance_of($other)
	{
		if (!is_a($this->th, $other))
		{
			throw new Exception(sprintf("Expected %s to be an instance of %s but was %s", $this->th, $other, get_class($this->th)));
		}
	}
}