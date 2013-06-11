<?php

class BasicClass
{

}

class ClassWithProperties
{
	public $property_one = 'foo';
	public $property_two = 'bar';

	public $public_property = 'hi!';
	private $private_property = 'nope';
}

class SimpleCalculator
{
	public function eulers_number()
	{
		return 2.71828;
	}
	
	public function negate($value)
	{
		return $value * -1;
	}
		
	public function add($a, $b)
	{
		return $a + $b;
	}
	
	public function multiply($a, $b)
	{
		return $a * $b;
	}
	
	public function divide($num, $den)
	{
		return $num / $den;
	}
	
	public function subtract($left, $right)
	{
		return $left - $right;
	}
	
	public function factorial($n)
	{
		if ($n < 0)
		{
			return null;
		}
		if ($n == 0)
		{
			return 1;
		}
		return $n * $this->factorial($n - 1);
	}
}

class ClassWithConstructor
{
	private $property_one = null;
	private $property_two = null;

	public function __construct($property_one, $property_two)
	{
		$this->property_one = $property_one;
		$this->property_two = $property_two;
	}

	public function get_value_string()
	{
		// sprintf formats strings
		return sprintf("%s and %s", $this->property_one, $this->property_two);
	}
}

class ClassWithDestructor
{
	private $callable = null;
	
	public function __construct(callable $callable)
	{
		$this->callable = $callable;
	}
	
	public function __destruct()
	{
		call_user_func($this->callable);
	}
}

class MagicClass
{
	public function __call($name, $args)
	{
		return "you called $name";
	}

	public function wello()
	{
		return 'wello!';
	}
}

class ClassWithStaticMethods
{
	private static $i = 100;

	public static function get_next_value()
	{
		return self::$i++;
	}

	public static function __callStatic($name, $args)
	{
		return "you statically called $name";
	}

	public static function wello()
	{
		return "wello!";
	}
}

class ClassWithToString
{
	private $string_value = 'Fortuna';

	public function set_string_value($string_value)
	{
		$this->string_value = $string_value;
	}

	public function __toString()
	{
		return $this->string_value;
	}
}

class ClassWithInvokeMethod
{
	public function __invoke($string)
	{
		// http://php.net/manual/en/function.strrev.php
		return strrev($string);
	}
}

interface Animal
{
	/**
	* Animal requires make_noise() and can_run() be
	* on implementors. Interfaces can't have any
	* conrete (filled-out) methods themselves.
	*/
	public function make_noise();

	public function can_run();
}

// implements -> Dog is an Animal

class Dog implements Animal
{
	public function make_noise()
	{
		return "woof!";
	}

	public function can_run()
	{
		return true;
	}
}

// Uncomment me and see what happens

// class Deer implements Animal
// {
// }


// Uncomment me and see what happens
// class AnyNoise implements Animal
// {
// 	public function __call($name, $args)
// 	{
//
// 	}
// }

abstract class Insect implements Animal
{
	public function can_run()
	{
		return false;
	}

	/**
	* Virgil says: In abstract classes, functions you want your subclasses
	* to implement must have the "abstract" keyword too.
	*/
	public abstract function can_fly();
}

class Ant extends Insect
{
	public function can_fly()
	{
		return false;
	}

	public function make_noise()
	{
		return "i'm an ant!";
	}
}

// Uncomment and see what happens

// class Cockroach extends Insect {}

interface Named
{
	public function get_name();
}

class Human implements Animal, Named
{
	private $name;

	public function __construct($name)
	{
		$this->name = $name;
	}

	public function can_run()
	{
		return true;
	}

	public function make_noise()
	{
		return "hello!";
	}

	public function get_name()
	{
		return $this->name;
	}
}

abstract class Monster
{
	public function attack()
	{
		return "ahh!";
	}
}

// Uncomment and see what happens

// class InsectMonster extends Insect, Monster {}

/**
* Traits are similar to abstract classes.
*/
trait Prodigality
{
	public function go_shopping()
	{
		$this->cash = max($this->cash - 1000, 0);
	}

	public abstract function address_of_ideal_house();
}

trait Avarice
{
	// "fairly" divide up cash between you and someone else
	public function split_wealth($cash)
	{
		$this->cash += $cash;
		return 0;
	}

}

class Entrepreneur
{
	// You can "use" more than one trait
	use Avarice, Prodigality;

	private $cash = 0;

	public function get_cash()
	{
		return $this->cash;
	}

	public function address_of_ideal_house()
	{
		return "101 Bayside Dr, Corona Del Mar CA.";
	}
}

// class Entrepreneur
// {
// 	public function additional_method()
// 	{
// 		return "wello";
// 	}
// }

class Plant
{
	protected static function color()
	{
		return "green";
	}

	protected function height_in_feet()
	{
		return 2;
	}

	public function description()
	{
		return sprintf("A living %s plant", self::color());
	}

	public function specific_description()
	{
		return sprintf("A living %s plant", static::color());
	}

	public function description_with_height()
	{
		return sprintf("A living %d-foot tall plant", $this->height_in_feet());
	}
}

class Tree extends Plant
{

	protected function height_in_feet()
	{
		return 15;
	}

	public function get_parent_height()
	{
		return parent::height_in_feet();
	}

	/**
	* This overrides the function in Plant
	*/
	protected static function color()
	{
		return "brown";
	}

	public function description_from_nuclear_powerplant()
	{
		return Nuclear_Power_Plant::amended_description();
	}
}

class Nuclear_Power_Plant
{
	public function description()
	{
		return "500 Mega Watt 'Hellhound' Nuclear Facility";
	}

	public function amended_description()
	{
		return $this->description() . " with a fully-featured cafeteria!";
	}
}

trait Tall
{

	public function height_in_feet()
	{
		return 100;
	}
}

class Bonsai_Tree extends Plant
{
	use Tall;
	
	public function height_in_feet()
	{
		return parent::height_in_feet();
	}
}

class CustomException extends Exception
{
	// that's it!
}