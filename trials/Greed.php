<?php

/**
* Classes, Interfaces, Traits and Namespaces
*/
class Greed
{
	public function classnames_are_strings()
	{
		
	}
	
	public function use_the_new_keyword_to_create_new_instances_of_a_class()
	{
		
	}
	
	public function instances_are_objects()
	{
		
	}
	
	public function objects_can_have_properties()
	{
		
	}
	
	public function objects_can_have_methods()
	{
		
	}
	
	public function objects_have_no_methods_at_all_by_default()
	{
		// unlike in other languages, where objects come with some baked-in tools
		
	}
	
	public function public_methods_and_properties_can_be_accessed_by_anyone()
	{
		
	}
	
	public function private_methods_can_only_be_accessed_inside_the_class()
	{
		
	}
	
	public function classes_are_always_public()
	{
		// there is no notion of a "protected class" in PHP
	}
	
	public function magic_methods_allow_objects_to_get_some_help_from_the_language()
	{
		// magic methods in PHP always start with two underscores
	}
	
	public function __call_lets_an_object_respond_to_any_method_call()
	{
		
	}
	
	public function static_methods_are_methods_a_classname_can_directly_respond_to()
	{
	
	}
	
	public function __callStatic_lets_a_classname_respond_to_any_static_method_call()
	{
		// static methods are generally bad practice - try to avoid them!
	}
	
	public function __toString_lets_you_turn_an_object_into_a_string_easily()
	{
		// PHP Quirk: toString() can never return null
	}
	
	public function __invoke_lets_you_make_an_object_callable()
	{
		
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