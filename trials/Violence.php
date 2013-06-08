<?php

require_once 'classes/Finally.php';

/**
* Exceptions and Errors
*/
class Violence
{
	public function exceptions_are_objects()
	{
		$exception = new Exception();
		assert_that(is_object($exception))->is_identical_to(__);
	}

	public function all_exceptions_descend_from_the_class_Exception()
	{
		$exception1 = new InvalidArgumentException();
		$exception2 = new BadMethodCallException();

		assert_that($exception1 instanceof Exception)->is_identical_to(__);
		assert_that($exception2 instanceof Exception)->is_identical_to(__);
	}

	public function exceptions_can_be_thrown_and_caught_which_interrupts_program_flow()
	{
		$value = 0;
		try
		{
			$value += 10;
			throw new Exception();
			$value += 50;
		}
		catch (Exception $e)
		{
			$value -= 5;
		}
		assert_that($value)->is_identical_to(__);
	}

	public function exceptions_are_caught_in_order_specified_by_the_catch_clauses()
	{
		$value = 0;
		try
		{
			throw new InvalidArgumentException();
		}
		catch(InvalidArgumentException $e)
		{
			$value = 5;
		}
		catch(Exception $e)
		{
			$value = 10;
		}
		assert_that($value)->is_identical_to(__);

	}

	public function exceptions_are_handled_as_soon_as_the_catch_type_matches()
	{
		$value = 0;
		try
		{
			throw new InvalidArgumentException();
		}
		catch (LengthException $e)
		{
			$value = 5;
		}
		catch (BadMethodCallException $e)
		{
			$value = 10;
		}
		catch (InvalidArgumentException $e)
		{
			$value = 20;
		}
		assert_that($value)->is_identical_to(__);
	}

	private function get_person_in_7th_circle($index)
	{
		$values = ['Geryon', 'Phlegethon', 'Polydorus'];
		if ($index >= count($values))
		{
			throw new OutOfBoundsException("Index is out of bounds");
		}
		return $values[$index];
	}

	public function a_distinct_exception_type_should_be_used_for_problems()
	{
		$message = null;

		try
		{
			$person = $this->get_person_in_7th_circle(4);
			if ($person != 'Phlegethon')
			{
				throw new DomainException('I only wanted Phlegethon');
			}
		}
		catch (Exception $e)
		{
			$message_to_customers = 'Sorry, you picked the wrong eternal sufferer. Please try again.';
		}

		assert_that($message_to_customers)->contains_string(__);
		assert_that(get_class($e))->is_identical_to(__);

		// Virgil says: Using a generic Exception handler (one that catches the base type Exception instead
		// of a subclass) is a bad idea. In this case, a program bug was presented to our customers
		// as an action that they need to take. Always catch the most specific exception possible.
	}

	public function custom_exceptions_are_straightforward()
	{
		// see classes/SampleClasses.php at the bottom
		try
		{
			throw new CustomException("wello!");
		}
		catch (CustomException $e)
		{

		}
		assert_that(get_class($e))->is_identical_to(__);
		assert_that($e->getMessage())->is_identical_to(__);
	}

	public function exceptions_have_error_codes_that_can_be_customized()
	{
		try
		{
			throw new CustomException("wello!", 10);
		}
		catch (CustomException $e)
		{

		}

		assert_that($e->getCode())->is_identical_to(__);
	}

	public function exceptions_have_a_stack_trace_you_can_inspect_for_debugging_purposes()
	{
		try
		{
			throw new CustomException();
		}
		catch (CustomException $e)
		{

		}
		$trace = $e->getTrace();
		// check out http://www.php.net/manual/en/function.debug-backtrace.php
		// for details about how it's structured

		assert_that($trace[0]['function'])->is_identical_to(__);
		assert_that($trace[0]['class'])->is_identical_to(__);
	}

	public function backtraces_can_be_generated_at_any_time()
	{
		$trace = debug_backtrace();

		assert_that($trace[0]['function'])->is_identical_to(__);
		assert_that($trace[0]['class'])->is_identical_to(__);
	}

	public function set_error_handler_can_be_used_to_intercept_nonfatal_php_errors()
	{
		$received_err_code = null;
		$received_err_message = null;
		set_error_handler(function($errno, $errmsg) use (&$received_err_message, &$received_err_code)
		{
			$received_err_code = $errno;
			$received_err_message = $errmsg;
		});

		// indexing a string with another string emits a warning
		$person = 'Phlegethon';
		$noop = $person['Geryon'];

		assert_that($received_err_code)->is_identical_to(__);
		assert_that($received_err_message)->contains_string(__);

		restore_error_handler();
	}
	public function trigger_error_can_be_used_to_emit_php_builtin_error_messages()
	{
		$received_err_code = null;
		$received_err_message = null;
		set_error_handler(function($errno, $errmsg) use (&$received_err_message, &$received_err_code)
		{
			$received_err_code = $errno;
			$received_err_message = $errmsg;
		});

		// Note: you can only trigger errors in the E_USER_* family of constants.
		// The second argument to this function can be an actual error value.
		// http://www.php.net/manual/en/errorfunc.constants.php
		trigger_error('Phlegethon translates to "river of fire"');

		assert_that($received_err_code)->is_identical_to(__);
		assert_that($received_err_message)->contains_string(__);

		restore_error_handler();
	}

	public function fatal_errors_are_uncatchable()
	{
		set_error_handler(function()
		{
			// nada
		});

		// uncomment me
		// trigger_error('You cannot stop me', E_USER_ERROR);
	}

	public function the_error_reporting_level_is_a_bitmask_over_what_error_types_are_emitted()
	{
		assert_that((error_reporting() & E_WARNING) > 0)->is_identical_to(__);
		assert_that((error_reporting() & E_STRICT) > 0)->is_identical_to(__);

		$old_value = error_reporting(E_ALL & ~E_STRICT); // calling it with an argument changes the reporting level

		assert_that((error_reporting() & E_WARNING) > 0)->is_identical_to(__);
		assert_that((error_reporting() & E_STRICT) > 0)->is_identical_to(__);

		error_reporting($old_value);
	}

	public function assert_can_be_used_to_emit_php_errors_when_a_precondition_fails()
	{
		// Virgil says: the function called "assert" is actually built-in to the language.

		$message = null;
		set_error_handler(function($errno, $errmsg) use (&$message)
		{
			$message = $errmsg;
		});

		assert(false);

		assert_that($message)->contains_string(__);

		restore_error_handler();
	}

	public function messages_can_be_passed_to_assertions_that_fail()
	{
		$message = null;
		set_error_handler(function($errno, $errmsg) use (&$message)
		{
			$message = $errmsg;
		});

		assert(false, "The harpies are everywhere!");

		assert_that($message)->contains_string(__);

		restore_error_handler();
	}

	public function setting_the_assert_bail_option_will_exit_process_unconditionally_even_though_message_is_at_warning_level()
	{
		// uncomment this and see what happens
		// assert_options(ASSERT_BAIL, true);

		set_error_handler(function($errno, $errmsg)
		{
			// hint: this is one of the PHP error level constants.
			// http://php.net/manual/en/errorfunc.constants.php
			assert_that($errno)->is_identical_to(__);
		});

		assert(false);

		restore_error_handler();
	}

	/**
	* Exercise VII. Finally!
	*
	* Having made it this far, you've already seen some of the darker things in the language.
	* Given all the idiosyncracies of PHP, it's well worth the effort to find safer ways
	* to achieve common patterns that are present in other languages.
	*
	* One such thing is the finally statement, which is a way of expressing that something should
	* happen no matter whether a try/catch block exited with an error or not. Here's what it looks
	* like in the yet-to-be-released PHP 5.5
	*
	* try
	* {
	*   $curl = new Curl();
	*   $curl->open();
	*   return $curl->get('http://something.com');
	* }
	* catch (HttpException $e)
	* {
	*   return "This service is not available";
	* }
	* finally
	* {
	*   $curl->close(); // free resources
	* }
	*
	* The contents of the finally block are guaranteed to be invoked, whether or not an exception
	* is thrown or a value is returned. Finally blocks are a concise way of expressing that the
	* same operation should happen in both the ok and error cases, which has to happen without
	* the finally statement:
	* try
	* {
	*   $curl = new Curl();
	*   $curl->open();
	*   $result = $curl->get('http://something.com');
	*   $curl->close();
	*   return $result;
	* }
	* catch (HttpException $e)
	* {
	*   $curl->close();
	*   return "This service is not available";
	* }
	*
	* Let's implement the finally block in PHP. If you are already on PHP 5.5, you are encouraged
	* to use the real thing.
	*
	* Note: because you cannot tell a function that returns null from a function that doesn't
	* have a return statement, our try-catch-finally mechanism won't be able to tell the difference.
	* Also note that using branching logic inside of finally statements is considered a Bad Idea, since
	* in can easily mask control logic happening in the try or catch blocks.
	*/

	public function try_catch_finally_simulator_correctly_runs_basic_functions()
	{
		$value = try_catch_finally(function()
		{
			return 50;
		});

		assert_that($value)->is_identical_to(50);
	}

	public function try_catch_finally_simulator_correctly_allows_you_to_pass_a_catch_clause_that_gets_executed_if_an_exception_is_thrown()
	{
		$value = try_catch_finally(function()
		{
			return 50;
		}, function()
		{
			return 10;
		});

		assert_that($value)->is_identical_to(50);
	}

	public function try_catch_finally_will_call_catch_clause_if_exception_is_thrown()
	{
		$value = try_catch_finally(function()
		{
			throw new Exception();
		}, function()
		{
			return 10;
		});

		assert_that($value)->is_identical_to(10);
	}

	public function try_catch_finally_will_call_finally_block_if_exception_not_thrown()
	{
		$called_finally = false;
		$value = try_catch_finally(function()
		{
			return 50;
		}, function()
		{
			return 10;
		}, function() use (&$called_finally)
		{
			$called_finally = true;
		});

		assert_that($value)->is_identical_to(50);
		assert_that($called_finally)->is_identical_to(true);
	}

	public function try_catch_finally_will_call_finally_block_if_exception_is_thrown()
	{
		$called_finally = false;
		$value = try_catch_finally(function()
		{
			throw new Exception();
		}, function()
		{
			return 10;
		}, function() use (&$called_finally)
		{
			$called_finally = true;
		});

		assert_that($value)->is_identical_to(10);
		assert_that($called_finally)->is_identical_to(true);
	}

}