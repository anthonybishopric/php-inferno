<?php

/**
* Type Interpolation
*/
class Heresy
{
	
	public function null_is_converted_to_empty_string_for_lexical_comparison()
	{
		
	}
	
	public function strings_that_evaluate_to_any_value_of_zero_are_equal_to_each_other_and_zero()
	{
		
	}
	
	public function strings_that_evaluate_to_the_digit_zero_are_falsey()
	{
		
	}
	
	public function strings_that_evaluate_to_a_value_of_zero_that_is_not_the_digit_zero_are_truthy()
	{
		
	}
	
	public function strings_are_converted_to_numbers_when_compared_or_added_to_numbers()
	{
		
		
		// Virgil says: PHP's odd string to number conversion didn't come out of thin air.
		// It is based on a Unix function written a while back. What's odd may not be the
		// function itself but it's implicit application...
		// http://www.exploringbinary.com/how-strtod-works-and-sometimes-doesnt/
	}
	
	/**
	* @suppress_warnings
	*/
	public function scalar_variables_that_are_not_strings_referenced_as_arrays_will_not_respond_to_array_operations()
	{
		$a = 100;
		$a[0] = 'Cavalcante';
		
		assert_that($a)->is_identical_to(100);
		
	}
	
	public function strings_that_are_referenced_as_arrays_will_not_be_manipulated_the_way_you_expect()
	{
		$a = 'Farinata';
		$a[0] = 'Cavalcante';
		assert_that($a)->is_identical_to('Carinata');
	}
	
	public function floats_are_not_precise_and_should_not_be_compared_for_equality()
	{
		$value = floor((0.1 + 0.7) * 10);
		
		assert_that($value)->is_equal_to(7);
		
		// Virgil says: This is actually a problem in any language that uses a binary value to store 
		// decimal values without arbitrary precision (including Java, Python, Ruby and many others):
		// http://stackoverflow.com/questions/1088216/whats-wrong-with-using-to-compare-floats-in-java
	}
	
	public function strings_are_compared_lexically()
	{
		
	}
	
	public function numbers_are_compared_through_normal_math()
	{
		
	}
	
	public function all_equality_comparisons_with_NAN_are_always_false()
	{
		
	}
	
	public function strings_that_represent_numbers_are_compared_like_numbers()
	{
		

		// Virgil says: the ways you can combine type interpolation and the comparison operators
		// are virtually endless.
		// http://stackoverflow.com/questions/15813490/php-type-juggling-and-strict-greater-lesser-than-comparisons
		// https://github.com/godka/php-comparisons
	}

	public function object_equality_is_based_on_the_classname_and_object_properties()
	{
		
	}
	
	public function object_containment_in_an_array_is_determined_by_equality_of_properties()
	{
		
	}
	
	public function object_containment_in_an_array_of_strings_determined_by_result_of__toString()
	{
		
	}

	
}