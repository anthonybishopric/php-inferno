<?php

/**
* Regular expressions
*/
class Lust
{
	public function collect_your_belongings()
	{
		$empty_array = []; // square brackets create an array
		assert_that(count($empty_array))->is_identical_to(0);
	}
	
	public function collect_your_thoughts()
	{
		$lovers = [];
		$lovers[0] ='francesca';
		$lovers[1] = 'paolo';
		
		assert_that($lovers)->is_identical_to(['francesca', 'paolo']);
	}
	
	public function collect_yourself()
	{
		$lovers = ['francesca', 'paolo'];
		
		assert_that($lovers[0])->is_identical_to('francesca');
		assert_that(array_shift($lovers))->is_identical_to('francesca');
		assert_that($lovers[0])->is_identical_to('paolo');
	}
	
	public function looks_can_be_deceiving()
	{
		$lovers = ['francesca', 'paolo'];
		
		unset($lovers[0]);
		assert_that($lovers[0])->is_identical_to(null);
		assert_that($lovers[1])->is_identical_to('paolo');
	}
	
	public function the_lovers_through_time()
	{
		$lovers = [
			'francesca' => 'guinivere',
			'paolo' => 'lancelot',
		];
		
		assert_that($lovers['francesca'])->is_equal_to('guinivere');
		assert_that(array_keys($lovers))->is_identical_to(['francesca', 'paolo']);
		assert_that(array_values($lovers))->is_identical_to(['guinivere', 'lancelot']);
	}
	
	public function caught_in_a_great_whirlwind()
	{
		
	}
}