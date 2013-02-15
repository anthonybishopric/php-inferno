<?php

require_once 'assertions.php';

class Pathway_Through_Darkness
{
	
	private $circles = array();
	
	public function __construct($classes)
	{
		foreach ($classes as $class)
		{
			require_once "trials/$class.php";
			$circle = new Circle($class);
			
			$rfl_class = new ReflectionClass($class);
			foreach ($rfl_class->getMethods() as $method)
			{
				$circle->add_trial($this->build_trial($rfl_class, $method));
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
					$failed_test_with_message = $trial->name . ":\n" . $e->getMessage();
					echo "\033[36m" . $failed_test_with_message . "\033[0m\n";
					return;
				}
			}
		}
		$this->print_total();
		echo "Some quote here\n";
	}
	
	private function build_trial($rfl_class, $method)
	{
		return new Trial(
					sprintf("In the circle of %s, %s", $rfl_class->name, $method->name),
					function() use ($rfl_class, $method)
					{
						$instance = $rfl_class->newInstance();
						$name = $method->name;
						$instance->$name();
					}
				);
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
	public function __construct($name, $fn)
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
}
	