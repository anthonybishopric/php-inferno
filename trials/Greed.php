<?php

require_once __DIR__ . '/classes/SampleClasses.php';

/**
* Classes, Interfaces, Traits and Namespaces
*/
class Greed
{
	// refer to classes/SampleClasses.php for these exercises.

	public function classnames_are_strings()
	{
		$class = 'BasicClass';

		assert_that(class_exists($class))->is_equal_to(true);
		assert_that(is_string($class))->is_equal_to(true);
	}

	public function use_the_new_keyword_to_create_new_instances_of_a_class()
	{
		$instance = new BasicClass();

		assert_that(is_a($instance, 'BasicClass'))->is_equal_to(true);
	}

	public function instances_are_objects()
	{
		$instance = new BasicClass();

		assert_that(is_object('BasicClass'))->is_equal_to(false);
		assert_that(is_object($instance))->is_equal_to(true);
	}

	public function objects_can_have_properties()
	{
		$instance_with_properties = new ClassWithProperties();
		assert_that($instance_with_properties->property_one)->is_identical_to('foo');
		assert_that($instance_with_properties->property_two)->is_identical_to('bar');
	}

	public function objects_can_have_methods()
	{
		$calculator = new SimpleCalculator();
		assert_that($calculator->add(1,2))->is_equal_to(3);
	}

	public function objects_have_no_methods_at_all_by_default()
	{
		// unlike in other languages, where objects come with some baked-in tools
		$instance = new BasicClass();
		assert_that(get_class_methods($instance))->is_identical_to([]);
	}

	public function private_methods_can_only_be_accessed_inside_the_class()
	{
		$with_properties = new ClassWithProperties();

		assert_that($with_properties->public_property)->is_equal_to('hi!');

		// Uncomment this line and see what happens
		// $with_properties->private_property;

		// Virgil says: it's a good idea to start off properties on a class
		// as private until you need them to be public, not the other way around.
	}

	public function static_methods_are_methods_a_classname_can_directly_respond_to()
	{
		// static methods are generally bad practice - try to avoid them!

		assert_that(ClassWithStaticMethods::get_next_value())->is_equal_to(100);
		assert_that(ClassWithStaticMethods::get_next_value())->is_equal_to(101);
	}

	public function classes_are_always_public()
	{
		// there is no notion of a "protected class" in PHP

		// Uncomment this line and see what happens
		// class IllegalNestedClass{}
	}

	public function __construct_is_called_with_arguments_to_new()
	{

	}

	public function __call_lets_an_object_respond_to_any_method_call_that_isnt_defined()
	{
		// magic methods in PHP always start with two underscores
		$magic = new MagicClass();

		assert_that($magic->foo())->is_identical_to('you called foo');
		assert_that($magic->bar())->is_identical_to('you called bar');
		assert_that($magic->wello())->is_identical_to('wello!');
	}


	public function __callStatic_lets_a_classname_respond_to_any_static_method_call_that_isnt_defined()
	{
		// static methods are generally bad practice - try to avoid them!

		assert_that(ClassWithStaticMethods::foo())->is_equal_to('you statically called foo');
		assert_that(ClassWithStaticMethods::bar())->is_equal_to('you statically called bar');
		assert_that(ClassWithStaticMethods::wello())->is_equal_to('wello!');

	}

	public function __toString_lets_you_turn_an_object_into_a_string_easily()
	{
		$instance = new ClassWithToString();

		assert_that("$instance")->is_equal_to("Fortuna");

		// PHP Quirk: __toString() can never return a non-string value
		// uncomment this and see what happens

		// $instance->set_string_value(null);
		// echo "$instance";
	}

	public function __invoke_lets_you_make_an_object_callable()
	{
		$instance = new ClassWithInvokeMethod();

		assert_that($instance("sedaH"))->is_equal_to('Hades');
	}

	public function interfaces_are_like_specs_for_a_class()
	{

	}

	public function a_class_must_implement_all_the_methods_of_an_interface()
	{

	}

	public function just_having_a___call_method_doesnt_mean_you_fit_an_interface()
	{

	}

	public function abstract_classes_are_like_interfaces_with_some_builtin_behavior()
	{

	}

	public function classes_can_implement_multiple_interfaces()
	{

	}

	public function classes_can_only_extend_one_class()
	{

	}

	public function traits_are_mixins_that_can_be_shared()
	{

	}

	public function traits_can_contain_abstract_methods()
	{

	}

	public function classes_can_use_multiple_traits()
	{
		// ActiveRecord is built with the programming by concerns model
		// see: http://37signals.com/svn/posts/3372-put-chubby-models-on-a-diet-with-concerns


	}

	public function classes_can_have_new_properties_assigned_at_runtime()
	{

	}

	public function classes_cannot_be_redefined_at_runtime_with_new_functions()
	{

	}

	public function classes_cannot_be_reopened_for_redefinition()
	{

	}

	public function the_self_keyword_can_be_used_to_call_static_methods_in_the_same_class()
	{

	}

	public function the_static_keyword_can_be_used_to_call_static_methods_as_well()
	{

	}

	public function self_will_always_refer_to_the_same_lexical_class_its_called_from()
	{

	}

	public function static_will_always_refer_to_the_most_specific_class_it_could_at_runtime()
	{

	}

	public function this_refers_to_the_object_that_you_are_in()
	{

	}

	/**
	* @suppress_warnings
	*/
	public function this_can_be_passed_between_classes_using_static_methods()
	{
		// NEVER EVER DO THIS INTENTIONALLY. It's super evil and violates all kinds
		// of coupling problems. If you find yourself doing this, reconsider
		// the design. Seriously.
	}

	public function exercise()
	{

	}
}