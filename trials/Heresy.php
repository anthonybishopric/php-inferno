<?php

require_once 'classes/Inventory.php';

/**
* Type Interpolation
*/
class Heresy
{

	public function null_is_converted_to_empty_string_for_lexical_comparison()
	{
		assert_that("" == null)->is_equal_to(true);
	}

	public function strings_that_evaluate_to_any_value_of_zero_are_equal_to_each_other_and_zero()
	{
		assert_that(0 == "0")->is_equal_to(true);
		assert_that("0" == "0.0")->is_equal_to(true);
		assert_that("0" == "00")->is_equal_to(true);
	}

	public function strings_that_evaluate_to_the_digit_zero_are_falsey()
	{
		$test = "0" ? true : false;
		assert_that($test)->is_equal_to(false);
	}

	public function strings_that_evaluate_to_a_value_of_zero_that_is_not_the_digit_zero_are_truthy()
	{
		$test = "0.0" ? true : false;
		assert_that($test)->is_equal_to(true);
	}

	public function strings_are_converted_to_numbers_when_compared_or_added_to_numbers()
	{
		$first = 9 + "5";
		$second = 10 + "Cavalcante";
		$third = 11 + "6th circle";

		assert_that($first)->is_equal_to(14);
		assert_that($second)->is_equal_to(10);
		assert_that($third)->is_equal_to(17);
		assert_that('Cavaltante' == 0)->is_equal_to(true);

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
		$string1 = 'abc';
		$string2 = 'abcd';
		$string3 = 'abc';

		assert_that($string1 == $string3)->is_equal_to(true);
		assert_that($string1 === $string3)->is_equal_to(true);
		assert_that($string1 < $string2)->is_equal_to(true);

		$strings = [$string2, $string3, $string1];
		sort($strings);

		assert_that($strings)->is_equal_to(['abc','abc','abcd']);
	}

	public function numbers_are_compared_through_normal_math()
	{
		$number1 = 1;
		$number2 = 3.3;
		$number3 = 1.0;

		assert_that($number1 == $number3)->is_equal_to(true);
		assert_that($number1 === $number3)->is_equal_to(false);
		assert_that($number1 < $number2)->is_equal_to(true);

		$numbers = [$number1, $number2, $number3];
		sort($numbers);

		assert_that($numbers)->is_equal_to([1, 1.0, 3.3]);
	}

	public function comparisons_with_NAN_are_always_false()
	{
		$number1 = 10;

		assert_that($number1 == NAN)->is_equal_to(false);
		assert_that($number1 > NAN)->is_equal_to(false);
		assert_that($number1 < NAN)->is_equal_to(false);
		assert_that(NAN == NAN)->is_equal_to(false);
	}

	public function strings_that_represent_numbers_are_compared_like_numbers()
	{
		$numeric1 = '123';
		$numeric2 = '124';
		$numeric3 = '0124';

		assert_that($numeric1 == '123')->is_equal_to(true);
		assert_that($numeric2 > $numeric1)->is_equal_to(true);
		assert_that($numeric3 > $numeric1)->is_equal_to(true);

		// Virgil says: the ways you can combine type interpolation and the comparison operators
		// are virtually endless. It's safe to say that the simplicity afforded by weak typing
		// is blown away when you have to reason about these comparison operators.
		// http://stackoverflow.com/questions/15813490/php-type-juggling-and-strict-greater-lesser-than-comparisons
		// https://github.com/godka/php-comparisons
	}

	public function object_equality_is_based_on_the_classname_and_object_properties()
	{
		$object1 = new ClassWithProperties();
		$object2 = new ClassWithProperties();

		assert_that($object1 == $object2)->is_equal_to(true);

		$object2->property_one = 'bye';

		assert_that($object1 == $object2)->is_equal_to(false);
	}

	public function object_containment_in_an_array_is_determined_by_equality_of_properties()
	{
		$object1 = new ClassWithProperties();
		$object2 = new ClassWithProperties();

		$array = [$object1];

		assert_that(in_array($object2, $array))->is_equal_to(true);
	}

	public function object_containment_in_an_array_of_strings_determined_by_result_of__toString()
	{
		$object1 = new ClassWithToString();
		$object1->set_string_value("wello!");

		$array1 = [$object1];

		assert_that(in_array('wello!', $array1))->is_equal_to(true);

		$array2 = ['wello!'];

		assert_that(in_array($object1, $array2))->is_equal_to(true);

		// Virgil says: For this reason, adding __toString to objects is a non-trivial
		// change to the functionality of your code. Be careful to understand the implications
		// of doing so!
	}

	/**
	* Exercise VI. The Power of Babel
	*
	* One of Epicurus's followers, Polyaenus, comes up to you, admitting that he had in life been
	* a PHP developer. He had spent much time crafting functions that reveled in the decadent
	* type juggling properties of PHP. In turn, he was punished for creating such untestable code.
	*
	* Virgil explains that he can begin his prayers of contrition by writing test cases that
	* validate his existing code's behavior. Once those tests are passing, he can change that
	* code to be safer using more strongly-typed paradigms. "Such is the path of a safe refactoring."
	*
	* Sure enough, the developer discovers that his original code doesn't work. You agree (reluctantly)
	* to help him fix his code so that the tests pass.
	*
	* (yes, there actually was a person in Epicurus's following named Polyaenus of Lampsacus)
	*
	* The code for reference is in classes/Inventory.php
	*/

	public function the_cow_inventory_parses_your_cow_fields_and_gives_you_a_sorted_list()
	{
		$info = Inventory::parse_inventory('Bessie, Marjorie, Bilbo');
		assert_that($info)->is_equal_to([
			'cows' => 3,
			'list' => ['Bessie', 'Bilbo', 'Marjorie']
		]);
	}

	public function the_cow_inventory_can_take_an_array_of_strings()
	{
		$info = Inventory::parse_inventory(['Bessie, Bilbo, Marjorie']);
		assert_that($info)->is_equal_to([
			'cows' => 3,
			'list' => ['Bessie', 'Bilbo', 'Marjorie']
		]);
	}

	public function the_cow_inventory_can_have_interestingly_named_cows()
	{
		$info = Inventory::parse_inventory(['Bessie, Bilbo, Marjorie, 0']);
		assert_that($info)->is_equal_to([
			'cows' => 4,
			'list' => ['0', 'Bessie', 'Bilbo', 'Marjorie']
		]);
	}
	
	public function each_name_can_be_its_own_entry()
	{
		$info = Inventory::parse_inventory(['Bessie', 'Bilbo', 'Marjorie', 0]);
		assert_that($info)->is_equal_to([
			'cows' => 4,
			'list' => ['0', 'Bessie', 'Bilbo', 'Marjorie']
		]);
	}

	public function the_cow_inventory_displays_frequencies_of_cow_names_when_passed_in_different_form()
	{
		$info = Inventory::parse_inventory(['Bessie, Bilbo, Marjorie, 0, Belinda'], 'freq');
		assert_that($info)->is_equal_to([
			'cows' => 5,
			'list' => ['0', 'Belinda', 'Bessie', 'Bilbo', 'Marjorie'],
			'freq' =>[
				'0' => 1,
				'B' => 3,
				'M' => 1
			]
		]);
	}
}