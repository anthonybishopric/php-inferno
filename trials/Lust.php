<?php

/**
* Arrays
*/
class Lust
{
	public function the_old_way_of_making_arrays()
	{
		$empty_array = array();
		assert_that(count($empty_array))->is_identical_to(0);
	}
	
	public function the_new_way_of_making_arrays()
	{
		$empty_array = []; // square brackets create an array
		assert_that(count($empty_array))->is_identical_to(0);
	}
	
	public function you_can_add_things_to_arrays()
	{
		$lovers = [];
		$lovers[0] ='francesca';
		$lovers[1] = 'paolo';
		
		assert_that($lovers)->is_identical_to(['francesca', 'paolo']);
	}
	
	public function array_literals_can_contain_values_at_init_time()
	{
		$lovers = ['francesca', 'paolo'];
		
		assert_that($lovers[0])->is_identical_to('francesca');
		assert_that(array_shift($lovers))->is_identical_to('francesca');
		assert_that($lovers[0])->is_identical_to('paolo');
	}
	
	/**
	* @suppress_warnings
	*/
	public function unsetting_a_key_deletes_the_value_in_place()
	{
		$lovers = ['francesca', 'paolo'];
		
		unset($lovers[0]);
		assert_that($lovers[0])->is_identical_to(null);
		assert_that($lovers[1])->is_identical_to('paolo');
	}
	
	/**
	* @suppress_warnings
	*/
	public function shifting_a_key_moves_the_remaining_keys_over()
	{
		$lovers = ['francesca', 'paolo'];
		
		$lover = array_shift($lovers);
		assert_that($lover)->is_identical_to('francesca');
		assert_that($lovers[0])->is_identical_to('paolo');
		assert_that($lovers[1])->is_identical_to(null);
	}
	
	public function arrays_can_have_string_keys()
	{
		$lovers = [
			'francesca' => 'guinivere',
			'paolo' => 'lancelot',
		];
		
		assert_that($lovers['francesca'])->is_equal_to('guinivere');
		assert_that(array_keys($lovers))->is_identical_to(['francesca', 'paolo']);
		assert_that(array_values($lovers))->is_identical_to(['guinivere', 'lancelot']);
	}

	public function arrays_can_become_associative_unintentionally()
	{
		// array_merge
	}
	
	public function for_loops_can_iterate_over_arrays()
	{
		
	}
	
	public function foreach_loops_save_a_variable()
	{
		
	}
	
	public function array_walk_can_do_the_same_thing()
	{
		
	}
	
	public function you_can_even_use_the_array_internal_pointer()
	{
		// this approach is generally dangerous though, so 
		// consider the other approaches instead.
	}
	
	public function you_can_implement_your_own_arrays()
	{
		
	}
	
	public function exercise()
	{
		
	}
}