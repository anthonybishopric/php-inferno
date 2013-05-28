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
		$with_constructor = new ClassWithConstructor("Fortuna", "Hades");
		$value = $with_constructor->get_value_string();
		
		assert_that($value)->is_equal_to("Fortuna and Hades");
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
		assert_that(interface_exists('Animal'))->is_equal_to(true);
		assert_that(class_exists('Animal'))->is_equal_to(false);
	}

	public function a_class_must_implement_all_the_methods_of_an_interface()
	{
		// uncomment the Deer class and see what happens
	}

	public function just_having_a___call_method_doesnt_mean_you_fit_an_interface()
	{
		// uncomment the AnyNoise class and see what happens
	}

	public function abstract_classes_are_like_interfaces_with_some_builtin_behavior()
	{
		$ant = new Ant();
		assert_that($ant->can_run())->is_equal_to(false);
	}

	public function classes_can_implement_multiple_interfaces()
	{
		$human = new Human("Bob");
		
		assert_that(is_a($human, 'Animal'))->is_equal_to(true);
		assert_that(is_a($human, 'Named'))->is_equal_to(true);
	}

	public function classes_can_only_extend_one_class()
	{
		// Uncomment the InsectMonster
	}

	public function traits_are_mixins_that_can_be_shared()
	{
		// ActiveRecord is built with the programming by concerns model, which
		// uses multiple traits.
		// see: http://37signals.com/svn/posts/3372-put-chubby-models-on-a-diet-with-concerns

		$entreprenur = new Entrepreneur();
		$entreprenur->split_wealth(5000);
		$entreprenur->go_shopping();
		$entreprenur->go_shopping();
		
		assert_that($entreprenur->get_cash())->is_equal_to(3000);
	}

	public function traits_can_contain_abstract_methods()
	{
		$entreprenur = new Entrepreneur();
		
		assert_that($entreprenur->address_of_ideal_house())->is_equal_to("101 Bayside Dr, Corona Del Mar CA.");
		
		// Try commenting out the function "address_of_ideal_house and see what happens"
	}


	public function classes_can_have_new_properties_assigned_at_runtime()
	{
		$entrepreneur = new Entrepreneur();

		$entrepreneur->new_property = "Social mobile photo filters";
		
		assert_that($entrepreneur->new_property)->is_identical_to("Social mobile photo filters");
		
		// Virgil says: although you can add new values to an object at runtime,
		// it's a bad idea. As of PHP 5.4, you get a 60% memory and speed boost by defining
		// all your properties ahead of time.
	}

	public function classes_cannot_be_redefined_at_runtime_with_new_functions()
	{
		$entrepreneur = new Entrepreneur();

		$entrepreneur->new_method = function()
		{
			return "wello!";
		};
		
		// uncomment me
		// $entrepreneur->new_method();
	}

	public function classes_cannot_be_reopened_for_redefinition()
	{
		// uncomment the second definition of Entrepreneur in SampleClasses
	}

	public function the_self_keyword_can_be_used_to_call_static_methods_in_the_same_class()
	{
		$tree = new Tree();
		assert_that($tree->description())->is_equal_to("A living green plant");
	}

	public function the_static_keyword_can_be_used_to_call_static_methods_as_well()
	{
		$tree = new Tree();
		assert_that($tree->specific_description())->is_equal_to("A living brown plant");
	}

	public function this_refers_to_the_object_that_you_are_in()
	{
		$plant = new Plant();
		assert_that($plant->description_with_height())->is_equal_to("A living 2-foot tall plant");
	}
	
	public function this_will_use_the_most_specific_method_it_can()
	{
		$tree = new Tree();
		assert_that($tree->description_with_height())->is_equal_to("A living 15-foot tall plant");		
	}

	/**
	* @suppress_warnings
	*/
	public function this_can_be_passed_between_classes_using_static_methods()
	{
		// Virgil politely says: Passing $this is evil and violates all kinds
		// of coupling problems. If you find yourself doing this, reconsider
		// the design. Seriously.
		
		$tree = new Tree();
		
		$desc_from_plant = $tree->description_from_nuclear_powerplant();
		
		assert_that($desc_from_plant)->is_equal_to("A living green plant with a fully-featured cafeteria!");
	}
	
	public function parent_refers_to_your_superclass_if_its_available()
	{
		$tree = new Tree();
		
		assert_that($tree->get_parent_height())->is_equal_to(2);
	}
	
	public function parent_will_go_to_your_superclass_and_not_a_trait()
	{
		$bonsai = new Bonsai_Tree();
		
		assert_that($bonsai->height_in_feet())->is_equal_to(2);
	}

	public function exercise()
	{

	}
}