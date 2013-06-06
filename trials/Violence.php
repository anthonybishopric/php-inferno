<?php

/**
* Exceptions and Errors
*/
class Violence
{
	public function exceptions_are_objects()
	{

	}

	public function all_exceptions_descend_from_the_class_Exception()
	{

	}

	public function exceptions_can_be_thrown_and_caught()
	{

	}

	public function exceptions_are_caught_in_order_specified_by_the_catch_clauses()
	{

	}

	public function a_distinct_exception_type_should_be_used_for_problems()
	{

	}

	public function custom_exceptions_are_straightforward()
	{

	}

	public function exceptions_have_error_codes_that_can_be_customized()
	{

	}

	public function trigger_error_can_be_used_to_emit_php_builtin_error_messages()
	{

	}

	public function try_catch_blocks_cannot_catch_php_errors()
	{

	}

	public function set_error_handler_can_be_used_to_intercept_nonfatal_php_errors()
	{

	}

	public function set_exception_handler_can_catch_uncaught_exceptions_at_a_global_level()
	{

	}

	public function fatal_errors_are_uncatchable()
	{

	}

	public function the_error_reporting_level_indicates_what_error_types_are_emitted()
	{

	}

	public function the_error_reporting_level_can_be_changed()
	{

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

		assert_that($message)->contains_string('Assertion failed');

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

		assert_that($message)->contains_string('The harpies');

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
			assert_that($errno)->is_identical_to(E_WARNING);
		});

		assert(false);

		restore_error_handler();
	}

	/**
	* Exercise VII. Finally!
	*
	* Having made it this far, you've already seen some of the darker things in the language.
	*
	*
	*/
}