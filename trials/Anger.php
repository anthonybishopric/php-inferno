<?php

require_once 'classes/Maybe.php';

/**
* Callables
*/
class Anger
{
	public function global_functions_are_callable_by_name()
	{
		assert_that(is_callable('assert_that'))->is_equal_to(true);
	}

	public function instance_methods_are_callables()
	{
		$method = ['Anger', 'instance_methods_are_callables'];
		assert_that(is_callable($method))->is_equal_to(true);
	}

	public function closures_are_inline_functions_and_are_callable()
	{
		$a_closure = function()
		{
			return "I am a closure!";
		};
		assert_that(is_callable($a_closure))->is_equal_to(true);
	}

	private $value = 10;

	private function a_private_function()
	{
		return $this->value * 2;
	}

	public function closures_inherit_their_context_by_default()
	{
		$a_closure = function()
		{
			return $this->a_private_function() - 5;
		};

		assert_that($a_closure())->is_equal_to(15);
	}

	public function closures_can_have_their_context_reassigned()
	{
		$add_five = function($value_to_add)
		{
			return $this->add($value_to_add, 5);
		};

		// this is the calculator from SampleClasses
		$calculator = new SimpleCalculator();

		$add_five = $add_five->bindTo($calculator);
		assert_that($add_five(10))->is_equal_to(15);
	}

	public function closures_arent_modified_only_created()
	{
		$test_on_this = function()
		{
			return method_exists($this, 'closures_arent_modified_only_created');
		};

		$calculator = new SimpleCalculator();
		$test_on_a_calculator = $test_on_this->bindTo($calculator);

		assert_that($test_on_this())->is_equal_to(true);
		assert_that($test_on_a_calculator())->is_equal_to(false);
	}

	public function any_local_variables_must_be_passed_explicitly_to_closures()
	{
		$the_furies = ['Megaera', 'Tisiphone', 'Allecto'];
		$get_fury = function($value) use ($the_furies)
		{
			return $the_furies[$value];
		};

		assert_that($get_fury(1))->is_equal_to('Tisiphone');
	}

	public function local_scalars_or_arrays_you_change_inside_a_closure_need_to_be_passed_by_reference()
	{
		$number_of_furies = null;

		$update_number_of_furies = function() use ($number_of_furies)
		{
			$number_of_furies = 3;
		};

		$update_number_of_furies();
		assert_that($number_of_furies)->is_identical_to(null);

		$actually_update_furies = function() use (&$number_of_furies)
		{
			$number_of_furies = 3;
		};

		$actually_update_furies();
		assert_that($number_of_furies)->is_identical_to(3);
	}

	public function classes_that_have_the__invoke_keyword_are_callable()
	{
		$instance = new ClassWithInvokeMethod();
		assert_that(is_callable($instance))->is_equal_to(true);
	}

	public function static_variables_in_functions_are_preserved_across_invocations()
	{
		$get_fury = function()
		{
			static $counter = 0;
			$the_furies = ['Megaera', 'Tisiphone', 'Allecto'];
			return $the_furies[$counter++];
		};

		assert_that($get_fury())->is_identical_to('Megaera');
		assert_that($get_fury())->is_identical_to('Tisiphone');
		assert_that($get_fury())->is_identical_to('Allecto');
	}

	public function type_hints_on_method_parameters_allow_you_to_check_input()
	{

		$count_of_furies = function(array $furies)
		{
			return count($furies);
		};

		assert_that($count_of_furies(['Megaera', 'Tisiphone', 'Allecto']))->is_equal_to(3);

		// uncomment this line and see what happens
		// assert_that($count_of_furies("Medusa"));
	}

	private function add_one($value)
	{
		return $value + 1;
	}

	public function the_callable_type_hint_lets_you_verify_that_only_callables_are_passed_to_a_function()
	{
		$call_my_function_with_10 = function(callable $your_function)
		{
			return $your_function(10);
		};

		assert_that($call_my_function_with_10([$this, 'add_one']))->is_equal_to(11);

		// http://www.php.net/manual/en/function.decbin.php
		assert_that($call_my_function_with_10('decbin'))->is_identical_to('1010');
	}

	public function default_values_can_be_assigned_to_parameters()
	{
		$does_horrifying_creature_turn_you_to_stone = function($monster = 'Medusa')
		{
			return $monster === 'Medusa';
		};

		assert_that($does_horrifying_creature_turn_you_to_stone())->is_equal_to(true);
		assert_that($does_horrifying_creature_turn_you_to_stone('Erichtho'))->is_equal_to(false);
	}

	public function null_carries_no_type_information()
	{
		$add_five_to_argument = function($argument, SimpleCalculator $calculator = null)
		{
			if (!$calculator)
			{
				$calculator = new SimpleCalculator();
			}
			return $calculator->add(5, $argument);
		};


		assert_that($add_five_to_argument(10))->is_equal_to(15);
		assert_that($add_five_to_argument(10), new SimpleCalculator())->is_equal_to(15);

		// try removing the "= null" default value assignment and see what happens
		assert_that($add_five_to_argument(10), null)->is_equal_to(15);
	}
	
	private function how_many_arguments()
	{
		$args = func_get_args();
		return count($args);
	}
	
	public function functions_can_reflect_on_their_arguments_as_arrays()
	{
		assert_that($this->how_many_arguments(1))->is_equal_to(1);
		assert_that($this->how_many_arguments(100, 200, 150))->is_equal_to(3);
	}
	
	public function functions_can_be_invoked_via_call_user_func()
	{
		$how_many = [$this, 'how_many_arguments'];
		
		$call_user_func_result = call_user_func($how_many, 10, 50);
		$call_user_func_array_result = call_user_func_array($how_many, [100, 200, 150]);
		
		assert_that($call_user_func_result)->is_equal_to(2);
		assert_that($call_user_func_array_result)->is_equal_to(3);
	}

	/**
	* Concatenate the values of an array together, like implode(), but with
	* a specified prefix and suffix.
	* @param string $prefix the first result
	* @param array $values the values to concatenate together
	* @param string $separator the separator
	* @param string|void $suffix the suffix of the value. Defaults to an empty string.
	* @return string the concatenated string.
	* @author FArgenti
	* @since 1.0.2
	*/
	private function concatenate_string($prefix, array $values, $separator, $suffix = "")
	{
		return $prefix . implode($values, $separator) . $suffix;
	}

	public function phpdoc_in_comments_is_a_standard_way_of_documenting_methods()
	{
		assert_that($this->concatenate_string('The primes less than 10 are ', [2, 3, 5, 7], ', ', '.'))->is_equal_to('The primes less than 10 are 2, 3, 5, 7.');

		// Virgil says: Making it this far down into the Inferno really has been tough! Although I
		// totally did it once before. Thankfully, this PHPDoc really helped me find my way. Leaving
		// documentation for others to find will surely help them along their journeys too.
	}

	public function doc_comments_can_be_accessed_programatically()
	{
		$anger_class = new ReflectionClass('Anger');
		$concatenate_string = $anger_class->getMethod('concatenate_string');
		$doc_comment = $concatenate_string->getDocComment();

		assert_true(strpos($doc_comment, "Concatenate") !== false);

		// Virgil says: Because comments are relatively expensive to calculate at runtime
		// in PHP, it's important to have some amount of intelligent caching built-in,
		// so consider using a 3rd party library to take care of this for you
		// https://packagist.org/search/?q=annotation
	}

	/**
	* Exercise V. Write Dis Function
	*
	* Part I. 
	*
	* Dis, the lower level of Hell including the 5th Circle and everything below, is depicted
	* as a city on the verge of war, with the Styx swamp encircling it. Naturally, the software
	* engineers trapped in the city of Dis enjoy functional programming.
	*
	* In this exercise you'll be implementing a chaining operation using only functions that allows
	* for safe execution over nullable values. Consider this example:
	*
	*  $some_value = some_function();
	*  $another_value = some_other_function($some_value);
	*  $final_value = last_function($another_value, 5);
	*  return $final_value;
	*
	* In the above cases, it's possible for any of the functions used to return null. In order to be safe about
	* execution in fully procedural code, we'd need to do something like this:
	*
	*  $some_value = some_function();
	*  if ($some_value === null) {
	* 	throw new UnexpectedValueException();
	*  }
	*  $another_value = some_other_function($some_value);
	*  if ($another_value === null) {
	* 	throw new UnexpectedValueException();
	*  }
	*  $final_value = last_function($another_value, 5);
	*  if ($final_value === null) {
	* 	throw new UnexpectedValueException();
	*  }
	*  return $final_value;
	*  
	* This code is hard to read and is heavily repetitive. To consolidate it, we'll implement three utility
	* functions called start(), andThen() and resolve()
	* 
	* The new code should look like this:
	* 
	* return start('some_function')
	*		->andThen('some_other_function') 
	* 		->andThen('last_function', 5)
	*		->resolve();
	*
	* Under the hood, the utility functions will perform the boilerplate code to pass arguments, handle
	* extra arguments sent to andThen and handle error cases appropriately.
	* 
	* The code to implement is in classes/Maybe.php
	*/	
	
	public function the_maybe_works_in_the_simple_case()
	{
		$simple = new SimpleCalculator();
		
		$value = start([$simple, 'eulers_number'])->resolve();
		assert_that($value)->is_equal_to(2.71828);
	}
	
	public function it_can_chain_several_calls()
	{
		$simple = new SimpleCalculator();
		
		$value = start([$simple, 'eulers_number'])
			->andThen([$simple, 'negate'])
			->resolve();
		
		assert_that($value)->is_equal_to(-2.71828);
	}
	
	public function arguments_are_passed_in_correctly()
	{
		$simple = new SimpleCalculator();
		
		$value = start([$simple, 'eulers_number'])
			->andThen([$simple, 'negate'])
			->andthen([$simple, 'multiply'], [10])
			->resolve();
		
		assert_that($value)->is_equal_to(-27.1828);
	}
	
	public function an_exception_is_thrown_for_anything_that_returns_null()
	{
		$simple = new SimpleCalculator();
		
		try
		{
			$value = start([$simple, 'eulers_number'])
				->andThen([$simple, 'negate'])
				->andThen([$simple, 'factorial'])
				->resolve();
			fail("Should not reach here");
		}
		catch (UnexpectedValueException $e)
		{
			
		}
		
		assert_that(get_class($e))->is_equal_to('UnexpectedValueException');
	}
	
	/** Part II
	* 
	* Now we have our basic MaybeMonad, let's add some syntactic sugar to make
	* it feel more natural.
	*
	* Let's use a proxy object on top of our target. This way
	* we can intercept all calls to it, delegate to the underlying function,
	* and get the safety of checking the return value.
	* 
	* It'll be clearer written out:
	*
	* $calculator = new SimpleCalculator();
	*
	* $value = new MaybeComprehension($calculator)
	*	->eulers_number()
	*	->negate()
	*	->multiply(10)
	*	->_maybe_resolve();
	*
	* This provides exactly the same behavior as before, just with fewer arrays and strings.
	*/
	
	public function the_comprehension_works_for_simple_calls()
	{
		$simple = new SimpleCalculator();
	
		$value = (new MaybeComprehension($simple))
			->eulers_number()
			->_maybe_resolve();
		assert_that($value)->is_equal_to(2.71828);
	}

	public function the_comprehension_chains_multiple_calls()
	{
		$simple = new SimpleCalculator();
	
		$value = (new MaybeComprehension($simple))
			->eulers_number()
			->negate()
			->_maybe_resolve();
		assert_that($value)->is_equal_to(-2.71828);
	}

	public function the_comprehension_comprehension_arguments_are_passed_correctly()
	{
		$simple = new SimpleCalculator();
	
		$value = (new MaybeComprehension($simple))
			->eulers_number()
			->negate()
			->multiply(10)
			->_maybe_resolve();
		assert_that($value)->is_equal_to(-27.1828);
	}
	
	public function the_comprehension_comprehension_errors_when_a_null_is_returned()
	{
		$simple = new SimpleCalculator();
	
		try
		{
			$value = (new MaybeComprehension($simple))
				->eulers_number()
				->negate()
				->multiply(10)
				->factorial()
				->_maybe_resolve();
			fail("Should not reach here");
		}
		catch (UnexpectedValueException $e)
		{
			
		}
		
		assert_that(get_class($e))->is_equal_to('UnexpectedValueException');
	}
}