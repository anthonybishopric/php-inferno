<?php

/**
* Arrays
*/
class Lust
{

	public function the_old_way_of_making_arrays()
	{
		$empty_array = array();
		assert_that(count($empty_array))->is_identical_to(__);
	}

	public function the_new_way_of_making_arrays()
	{
		$empty_array = []; // square brackets create an array
		assert_that(count($empty_array))->is_identical_to(__);
	}

	public function arrays_are_neither_objects_nor_scalars()
	{
		$array = [];
		assert_that(is_object($array))->is_identical_to(__);
		assert_that(is_scalar($array))->is_identical_to(__);
	}

	public function you_can_add_things_to_arrays()
	{
		$lovers = [];
		$lovers[0] ='francesca';
		$lovers[1] = 'paolo';

		assert_that($lovers)->is_identical_to(__);
	}
	public function array_literals_can_contain_values_at_init_time()
	{
		$lovers = ['francesca', 'paolo'];

		assert_that($lovers[0])->is_identical_to(__);
		assert_that(array_shift($lovers))->is_identical_to(__);
		assert_that($lovers[0])->is_identical_to(__);
	}

	/**
	* @suppress_warnings
	*/
	public function unsetting_a_key_deletes_the_value_in_place()
	{
		$lovers = ['francesca', 'paolo'];

		unset($lovers[0]);
		assert_that($lovers[0])->is_identical_to(__);
		assert_that($lovers[1])->is_identical_to(__);
	}

	/**
	* @suppress_warnings
	*/
	public function shifting_a_key_moves_the_remaining_keys_over()
	{
		$lovers = ['francesca', 'paolo'];
		$lover = array_shift($lovers);
		assert_that($lover)->is_identical_to(__);
		assert_that($lovers[0])->is_identical_to(__);
		assert_that($lovers[1])->is_identical_to(__);
	}

	public function arrays_can_have_string_keys()
	{
		$lovers = [
			'francesca' => 'guinivere',
			'paolo' => 'lancelot',
		];

		assert_that($lovers['francesca'])->is_equal_to(__);
		assert_that(array_keys($lovers))->is_identical_to(__);
		assert_that(array_values($lovers))->is_identical_to(__);
	}

	public function array_keys_are_ordered()
	{
		// PHP's arrays are implemented as ordered hashes.
		$lovers = [
			'francesca' => 'guinivere',
			'paolo' => 'lancelot'
		];

		$lovers_again = [
			'paolo' => 'lancelot',
			'francesca' => 'guinivere',
		];

		assert_that($lovers == $lovers_again)->is_equal_to(__);
		assert_that($lovers === $lovers_again)->is_equal_to(__);
	}

	public function array_key_exists_to_test_for_a_key_in_an_array_even_if_no_value_set()
	{
		$lovers = [
			'francesca' => 'guinivere',
			'paolo' => 'lancelot',
			'forever_alone' => null
		];

		assert_that(array_key_exists('francesca', $lovers))->is_equal_to(__);
		assert_that(array_key_exists('forever_alone', $lovers))->is_equal_to(__);
		assert_that(array_key_exists('romeo', $lovers))->is_equal_to(__);
	}

	public function use_isset_to_to_test_if_a_value_is_set_as_well_as_the_key()
	{
		$lovers = [
			'francesca' => 'guinivere',
			'paolo' => 'lancelot',
			'forever_alone' => null
		];

		assert_that(isset($lovers['francesca']))->is_equal_to(__);
		assert_that(isset($lovers['forever_alone']))->is_equal_to(__);
		assert_that(isset($lovers['romeo']))->is_equal_to(__);
	}

	public function empty_is_the_exact_opposite_of_isset()
	{
		$lovers = [
			'francesca' => 'guinivere',
			'paolo' => 'lancelot',
			'forever_alone' => null,
		];

		assert_that(empty($lovers['francesca']))->is_equal_to(__);
		assert_that(empty($lovers['forever_alone']))->is_equal_to(__);
		assert_that(empty($lovers['romeo']))->is_equal_to(__);
	}

	/*
	Virgil says: You shouldn't test arrays without using a function. The statement

	if ($my_array[$key])
	{
		....
	}

	works but it's ambiguous what its semantics are. If you use this on an array where the
	key is missing, PHP will emit a warning.

	*/

	public function array_merge_combines_two_arrays()

	{
		$lovers = ['francesca' => 'guinivere', 'paolo' => 'lancelot'];
		$more_lovers = ['paolo' => 'romeo', 'romeo' => 'leonardo'];

		$all_lovers = array_merge($lovers, $more_lovers);

		assert_that($all_lovers)->is_equal_to(__);
	}

	public function array_merge_loses_numeric_keys()
	{
		// !! be careful when using array merge - this quirk can really hurt
		// see: this famous bug caused by array_merge()
		// http://blogs.wsj.com/digits/2010/02/25/facebook-glitch-sends-messages-to-the-wrong-people/tab/article/

		$some_user_ids = [101 => 'francesca', 102 => 'paolo'];
		$more_user_ids = [103 => 'lancelot', 104 => 'guinivere'];

		$all_user_ids = array_merge($some_user_ids, $more_user_ids);

		assert_that($all_user_ids)->is_equal_to(__);
	}

	public function for_loops_can_iterate_over_arrays()
	{
		$a = ['francesca', 'loves', 'paolo'];
		$b = [];
		for ($i = 0; $i < count($a); $i++)
		{
			$word = $a[$i];
			array_unshift($b, $word);
		}
		assert_that($b)->is_equal_to(__);
	}

	public function foreach_loops_save_a_variable()
	{
		$a = ['francesca', 'loves', 'paolo'];
		$b = [];
		foreach ($a as $word)
		{
			array_unshift($b, $word);
		}
		assert_that($b)->is_equal_to(__);
	}

	public function array_walk_can_do_the_same_thing()
	{
		// the & lets you pass scalars and arrays by reference. normally
		// they are copied by value
		$a = ['francesca', 'loves', 'paolo'];
		$b = [];
		array_walk($a, function($word) use (&$b)
		{
			array_unshift($b, $word);
		});
		assert_that($b)->is_equal_to(__);
	}

	public function you_can_even_use_the_array_internal_pointer()
	{
		// this approach is generally dangerous though, so
		// consider the other approaches instead.
		$a = ['francesca', 'loves', 'paolo'];
		$b = [];

		end($a);
		do
		{
			$b[] = current($a);
		}
		while(prev($a) !== false);

		assert_that($b)->is_equal_to(__);

		task('consider why is this a bad idea');
	}

	/**
	* Exercise II. Reverse Arrays.
	*
	* In this exercise you'll need to implement the methods in
	* classes/ReverseArray.php
	*
	* Implementing custom classes that have array operators can be very useful.
	* Sometimes you want to be able to have array semantics. In this case,
	* we want to be able to automatically reverse the contents of an array using
	* a custom array implementation.
	*/

	public function reverse_arrays_automatically_reverse_the_contents_given()
	{
		require_once __DIR__ . '/classes/ReverseArray.php';

		$a = ['francesca', 'loves', 'paolo'];
		$reverse_array = new ReverseArray(count($a) - 1);

		for($i = 0; $i < count($a); $i++)
		{
			$reverse_array[$i] = $a[$i];
		}
		assert_that($reverse_array->getInternalArray())->is_equal_to(['paolo', 'loves', 'francesca']);
	}

}