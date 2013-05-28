<?php

require_once 'assertions.php';

class Pathway_Through_Darkness
{
	
	private $circles = array();
	
	public function __construct(array $classes)
	{
		foreach ($classes as $class)
		{
			require_once "trials/$class.php";
			$circle = new Circle($class);
			
			$rfl_class = new ReflectionClass($class);
			foreach ($rfl_class->getMethods() as $method)
			{
				if ($method->isPublic())
				{
					$circle->add_trial($this->build_trial($rfl_class, $method));
				}
			}
			$this->circles[] = $circle;
		}
	}
	
	public function descend()
	{
		foreach ($this->circles as $circle)
		{
			foreach ($circle->trials() as $trial)
			{
				try
				{
					$trial->run();
				}
				catch (Exception $e)
				{
					$this->print_total();
					$this->print_message($trial, $e);
					return;
				}
			}
		}
		$this->print_total();
		echo "Some quote here\n";
	}
	
	private function build_trial(ReflectionClass $rfl_class, ReflectionMethod $method)
	{
		return new Trial(
					sprintf("In the circle of %s, %s", $rfl_class->name, $method->name),
					function() use ($rfl_class, $method)
					{
						$instance = $rfl_class->newInstance();
						$name = $method->name;
						$this->call_with_aspects($method, function() use ($instance, $name) 
						{ 
							$instance->$name();
						});
					}
				);
	}

	private function call_with_aspects(ReflectionMethod $method, callable $fn)
	{
		$comment = $method->getDocComment();
		$matches = [];
		preg_match_all('/@([a-zA-Z\_]+)/', $comment, $matches);
		if (count($matches) > 1 && in_array('suppress_warnings', $matches[1]))
		{
			$old_level = error_reporting();
			$new_level = $old_level ^ E_WARNING ^ E_NOTICE ^ E_STRICT;
			error_reporting($new_level);
		}
		$fn();
		if (isset($old_level))
		{
			error_reporting($old_level);
		}
	}
	
	private function print_total()
	{	
		$total = 0;
		$completed = 0;
		foreach ($this->circles as $circle)
		{
			$total+= count($circle);
			$completed += $circle->count_of_completed();
			echo $circle->completion_string() . "\n";
		}
		echo "\n\033[33m$completed / $total trials conquered\033[0m\n";
	}
	
	private function print_message(Trial $trial, Exception $e)
	{
		$frame = $e->getTrace()[0];
		$file = $frame['file'];
		$line_number = $frame['line'];
		$failed_test_with_message = $trial->name . ":\n" . $file. ":" .$line_number . "\n" . $e->getMessage();
		echo "\033[36m" . $failed_test_with_message . "\033[0m\n";
	}
}

class Circle implements Countable
{
	private $name = null;
	private $trials = array();
	
	public function __construct($name)
	{
		$this->name = $name;
	}
	
	public function add_trial(Trial $trial)
	{
		$this->trials[] = $trial;
	}
	
	public function trials()
	{
		return $this->trials;
	}
	
	public function count()
	{
		return count($this->trials);
	}
	
	public function complete()
	{
		return $this->count() == $this->count_of_completed();
	}
	
	public function count_of_completed()
	{
		$completed = 0;
		foreach ($this->trials as $trial)
		{
			$completed += $trial->complete() ? 1 : 0;
		}
		return $completed;
	}
	
	public function completion_string()
	{
		$str = '';
		foreach ($this->trials as $trial)
		{
			$str .= $trial->status_char();
		}
		return $this->name . "\n$str";
	}
}

class Trial
{
	public function __construct($name, callable $fn)
	{
		$this->name = $name;
		$this->fn = $fn;
		$this->completed = false;
		$this->failed = false;
	}
	
	public function run()
	{
		try
		{
			$fn = $this->fn;
			$fn();
			$this->completed = true;	
		}
		catch(Exception $e)
		{
			$this->failed = true;
			throw $e;
		}
	}
	
	public function complete()
	{
		return $this->completed;
	}
	
	public function name()
	{
		return $this->name;
	}
	
	public function status_char()
	{
		if ($this->completed)
		{
			return "\033[32m✞\033[0m";
		}
		else if($this->failed)
		{
			return "\033[31m♆\033[0m";
		}
		else
		{
			return ".";
		}
	}
}

class _{
	const _ = "FILL ME IN";
	const __ = false;
}
	