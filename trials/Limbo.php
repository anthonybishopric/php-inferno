<?php

/** 
* Basics
*/
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

	public function find_what_is_true___()
	{
		$hells_circles = 9;
		assert_true($hells_circles == 9);
	}

	public function __and_tell_it_on_the_mount()
	{
		$hells_circles = 9;
		assert_that($hells_circles)->is_equal_to(9);
	}
	
	public function though_you_may_find_truth_is_not_always_easy_to_find()
	{
		$virgil = "the poet";
		assert_that($virgil == true)->is_equal_to(true);
		assert_that($virgil === true)->is_equal_to(false);
		assert_that($virgil)->is_identical_to("the poet");
	}

	public function null_is_nothing()
	{
		$nothing = null;
		assert_that($nothing == '')->is_equal_to(true);
	}

	/**
	* @suppress_warnings
	*/
	public function sometimes_you_will_have_nothing_to_go_by()
	{
		assert_that($undeclared)->is_equal_to(false);
	}

	// branching / looping	

}