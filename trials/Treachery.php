<?php

require_once __DIR__ . '/classes/Betrayals.php';

class Treachery
{
	/*
	Virgil says: congratulations, you've made it to the most depraved pits of darkness 
	in PHP. As you'll see, there are many things that will try to bite you down here. 
	You'll notice many of the atrocities can be caught early with judicious use of high
	error reporting levels, and you are strongly encouraged to keep your error reporting
	level at E_ALL. 
	*/
	
	/**
	 * @suppress_warnings
	 */
	public function referencing_a_string_as_an_array()
	{
		$the_message = "Antenora";
		$another_string = "Caina";
		$a_third_string = '3 circles';

		assert_that(isset($the_message[$another_string]))->is_equal_to(false);
		assert_that($the_message[$another_string])->is_equal_to('A');
		assert_that($the_message[$a_third_string])->is_equal_to('e');

	}

	public function call_vs_call_static_in_context()
	{
		$dynamic = new DynamicClass();

		assert_that($dynamic->foo())->is_equal_to('__call(foo)');
		assert_that($dynamic->bar())->is_equal_to('__call(bar)');

		// so far so good...

		assert_that(DynamicClass::foo())->is_equal_to('__callStatic(foo)');
		assert_that(DynamicClass::bar())->is_equal_to('__callStatic(bar)');

		// ok....

		// the answer to this depends on the version of PHP you're running.
		// PHP 5.4.10 has a different value from PHP 5.4.13+
		assert_that($dynamic::foo())->is_equal_to('__callStatic(foo)');
	}

	/**
	* @suppress_warnings
	*/
	public function the_static_keyword_basically_doesnt_matter()
	{
		$calculator = new ScrewedCalculator();
		assert_that($calculator->add(1, 2))->is_equal_to(3);
		assert_that($calculator->multiply(3, 5))->is_equal_to(15);

		assert_that(ScrewedCalculator::add(1, 2))->is_equal_to(3);
		assert_that(ScrewedCalculator::multiply(3, 5))->is_equal_to(15);

		// Virgil says: this is a betrayal of what it means to be an
		// instance method. If you want a method to be called statically,
		// always mark it static. If you don't, omit the static keyword.
	}

	public function null_is_equal_to_zero_and_less_than_negative_one()
	{
		$value = null;

		assert_that($value < -1 && $value == 0)->is_equal_to(true);
	}

	public function needle_haystack_on_builtin_functions_is_confusing()
	{
		$giants = ['Briareus', 'Tityus', 'Typhon'];

		$giant_string = implode($giants, ',');
		$giant_string_again = implode(',', $giants);

		assert_that($giant_string === $giant_string_again)->is_equal_to(true);

		$is_tityus = function($giant)
		{
			return $giant === 'Tityus';
		};

		$map = array_map($is_tityus, $giants);
		assert_that($map)->is_equal_to([false, true, false]);

		$filter = array_filter($giants, $is_tityus);
		assert_that($filter)->is_equal_to([1 => 'Tityus']);

		// Virgil says: remembering whether the function is the first or second argument gets
		// me every time! PHP's string functions often exhibit this behavior.
	}

	private function helper_function()
	{
		return 2;
	}

	public function this_can_be_reassigned_with_black_magic()
	{
		// you can't reassign $this - it's a terrible idea!
		// try uncommenting:
		// $this = 'foo';

		assert_that(is_string($this))->is_equal_to(false);
		assert_that($this->helper_function())->is_equal_to(2);

		// and yet...

		$this_string = 'this';
		$$this_string = 'foo'; // the "bling bling" operator.

		assert_that(is_string($this))->is_equal_to(true);
		assert_that($this)->is_equal_to('foo');
		assert_that($this->helper_function())->is_equal_to(2);
	}

	public function catchable_fatal_errors()
	{
		// http://php.net/manual/en/function.set-error-handler.php
		set_error_handler(function($errno, $errstr)
		{
			return $errno == E_RECOVERABLE_ERROR;
		});

		$get_brothers_name = function(Abel $abel)
		{
			return get_class($abel->brother());
		};

		// roll right through that type hint
		$name = $get_brothers_name(new Cain());

		assert_that($name)->is_identical_to('Abel');

		restore_error_handler();
	}
	
	/**
	* @suppress_warnings
	*/
	public function less_than_operator_is_pretty_optimistic()
	{
		$a = INF;
		$b = [];
		$c = $this;
		
		assert_that($a < $b)->is_identical_to(true);
		assert_that($b < $c)->is_identical_to(true);
		assert_that($c < $a)->is_identical_to(true);
	}

	/**
	* @suppress_warnings
	*/
	public function json_encode_of_infinity()
	{
		$encoded = json_encode(['mansion' => 2500000, 'love' => INF]);

		$decoded = json_decode($encoded);

		assert_that($decoded->mansion)->is_identical_to(2500000);

		assert_that($decoded->love)->is_identical_to(0);
	}

	public function ternary_operator_precedence_is_backwards()
	{
		// Virgil says: Beware the ternary operator. PHP is the only mainstream
		// language that uses left associative ternary operators, making
		// nested ternaries even harder to understand.

		$first = false ? null : "Brutus";

		assert_that($first)->is_identical_to("Brutus");

		$second = false ? null : "Brutus" ? "Cassius" : null;

		assert_that($second)->is_identical_to("Cassius");

		$third = true ? "Brutus" : null ? "Judas" : null;

		assert_that($third)->is_identical_to("Judas");
	}

	// private $foo = "one" . "two";

	public function cant_do_static_concatenation_of_any_objects()
	{
		// try uncommenting the assignment above
	}

	public function the_at_operator()
	{
		$get_error_reporting_level = function()
		{
			return error_reporting();
		};

		$old_reporting_level = error_reporting();

		assert_true($old_reporting_level !== 0);

		assert_that($get_error_reporting_level())->is_identical_to($old_reporting_level);
		assert_that(@$get_error_reporting_level())->is_identical_to(0);

		// Virgil says: the @ operator suppresses every error you
		// get, making debugging almost impossible. It's also incredibly
		// confusing the first time you see it, as it's almost totally
		// un-Google-able!
	}

	public function arbitrary_expressions_in_switch_statements()
	{
		$color = 'RED';

		$get_red = function(){
			return "RED";
		};

		$value = null ;
		switch($color)
		{
			case 'BLUE':
				$value = '#00F';
				break;
			case str_repeat('G',10):
				$value = '#0F0';
				break;
			case $get_red():
				$value = '#F00';
				break;

		};
		assert_that($value)->is_equal_to('#F00');
	}

	public function you_can_use_braces_to_do_array_indexing()
	{
		$an_array = [1,2,3];
		assert_that($an_array{1})->is_equal_to(2);
	}


	public function floats_and_doubles_are_the_same_thing()
	{
		// Unlike C++/Java, where floats and doubles have different precision.

		$a_float = (float) 3.3;
		$a_double = (double) 3.3;
		$a_real = (real) 3.3;

		assert_that(gettype($a_float))->is_identical_to(gettype($a_double));
		assert_that(gettype($a_real))->is_identical_to(gettype($a_double));
	}

	public function constructs_that_look_like_functions()
	{
		/*
		* Virgil says: a number of function look-alikes exist in PHP.
		* Although they function like normal functions lots of the time,
		* they can have weird semantics or inconsistent syntax. Beware!
		*/

		// unset() and isset() won't accept non-variables. In fact, if you pass a literal
		// like "foo" it will result in a parse error!
		$the_lake = 'Cocytus';
		assert_that(isset($the_lake))->is_equal_to(true);
		unset($the_lake);
		assert_that(isset($the_lake))->is_equal_to(false);
		assert_that(function_exists('isset'))->is_equal_to(false);

		// list() and array() have parentheses but they are very far
		// from being functions.
		list($manfred, $alberigo) = array('bring', 'the fruit!');
		assert_that($manfred)->is_equal_to('bring');
		assert_that($alberigo)->is_equal_to('the fruit!');
	}
}