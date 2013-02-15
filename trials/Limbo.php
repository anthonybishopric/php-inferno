<?php

class Limbo
{
	public function seek_the_truth()
	{
		assert_true(true); // make this true
	}
	
	public function dispatch_the_lies()
	{
		$the_sky_is_red = false;
		assert_true($the_sky_is_red == false); // make this false
	}
	
	public function decide_what_stays_constant___()
	{
		$hells_circles = 9;
		assert_true($hells_circles == 9);
	}
	
	public function __and_speak_it_clearly()
	{
		$hells_circles = 9;
		assert_that($hells_circles)->is_equal_to(9);
	}
	
}