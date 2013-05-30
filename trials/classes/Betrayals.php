<?php

class DynamicClass
{
	public function __call($name, $args)
	{
		return "__call($name)";
	}

	public static function __callStatic($name, $args)
	{
		return "__callStatic($name)";
	}
}

class ScrewedCalculator
{
	public function add($a, $b)
	{
		return $a + $b;
	}

	public static function multiply($a, $b)
	{
		return $a * $b;
	}
}

interface Related
{
	public function brother();
}

class Abel implements Related
{
	public function brother()
	{
		return new Cain();
	}
}

class Cain implements Related
{
	public function brother()
	{
		return new Abel();
	}
}

// final abstract class AbstractFinalClass
// {
//
// }