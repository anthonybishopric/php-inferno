<?php

require_once __DIR__ . '/classes/SampleClasses.php';
require_once __DIR__ .  '/classes/Salespeople.php';
/**
* Classes, Interfaces, Traits and Namespaces
*/
class Greed
{
	// refer to classes/SampleClasses.php for these exercises.

	public function classnames_are_strings()
	{
		$class = 'BasicClass';

		assert_that(class_exists($class))->is_identical_to(__);
		assert_that(is_string($class))->is_identical_to(__);
	}

	public function use_the_new_keyword_to_create_new_instances_of_a_class()
	{
		$instance = new BasicClass();

		assert_that(is_a($instance, 'BasicClass'))->is_identical_to(__);
	}

	public function instances_are_objects()
	{
		$instance = new BasicClass();

		assert_that(is_object('BasicClass'))->is_identical_to(__);
		assert_that(is_object($instance))->is_identical_to(__);
	}

	public function objects_can_have_properties()
	{
		$instance_with_properties = new ClassWithProperties();
		assert_that($instance_with_properties->property_one)->is_identical_to(__);
		assert_that($instance_with_properties->property_two)->is_identical_to(__);
	}

	public function objects_can_have_methods()
	{
		$calculator = new SimpleCalculator();
		assert_that($calculator->add(1,2))->is_identical_to(__);
	}

	public function objects_have_no_methods_at_all_by_default()
	{
		// unlike in other languages, where objects come with some baked-in tools
		$instance = new BasicClass();
		assert_that(get_class_methods($instance))->is_identical_to(__);
	}

	public function private_methods_can_only_be_accessed_inside_the_class()
	{
		$with_properties = new ClassWithProperties();

		assert_that($with_properties->public_property)->is_identical_to(__);

		task('uncomment the following line');
		// $with_properties->private_property;

		// Virgil says: it's a good idea to start off properties on a class
		// as private until you need them to be public, not the other way around.
	}

	public function static_methods_are_methods_a_classname_can_directly_respond_to()
	{
		// static methods are generally bad practice - try to avoid them!

		assert_that(ClassWithStaticMethods::get_next_value())->is_identical_to(__);
		assert_that(ClassWithStaticMethods::get_next_value())->is_identical_to(__);
	}

	public function classes_are_always_public()
	{
		// there is no notion of a "protected class" in PHP

		task('uncomment the following line');
		// class IllegalNestedClass{}
	}

	public function __construct_is_called_with_arguments_to_new()
	{
		$with_constructor = new ClassWithConstructor("Fortuna", "Hades");
		$value = $with_constructor->get_value_string();

		assert_that($value)->is_identical_to(__);
	}
	
	public function methods_with_same_name_as_class_act_as_constructors()
	{
		$with_constructor = new ClassWithNameAsConstructor("Fortuna", "Hades");
		$value = $with_constructor->get_value_string();

		// Virgil says: Beware, classname constructor methods are case insensitive.
		// A class 'Hades' with a method 'hades()' would call 'hades()' as its constructor.
		assert_that($value)->is_identical_to(__);
	}

	public function __destruct_is_called_when_nobody_references_the_object_anymore()
	{
		$called_it = false;
		
		$with_destruct = new ClassWithDestructor(function() use (&$called_it)
		{
			$called_it = true;
		});
		
		assert_that($called_it)->is_identical_to(__);
		
		$with_destruct = null; // no more references to $with_destruct exist
		
		assert_that($called_it)->is_identical_to(__);
	}

	public function __call_lets_an_object_respond_to_any_method_call_that_isnt_defined()
	{
		// magic methods in PHP always start with two underscores
		$magic = new MagicClass();

		assert_that($magic->foo())->is_identical_to(__);
		assert_that($magic->bar())->is_identical_to(__);
		assert_that($magic->wello())->is_identical_to(__);
	}


	public function __callStatic_lets_a_classname_respond_to_any_static_method_call_that_isnt_defined()
	{
		// static methods are generally bad practice - try to avoid them!

		assert_that(ClassWithStaticMethods::foo())->is_identical_to(__);
		assert_that(ClassWithStaticMethods::bar())->is_identical_to(__);
		assert_that(ClassWithStaticMethods::wello())->is_identical_to(__);

	}

	public function __toString_lets_you_turn_an_object_into_a_string_easily()
	{
		$instance = new ClassWithToString();

		assert_that("$instance")->is_identical_to(__);

		// PHP Quirk: __toString() can never return a non-string value
		
		task('uncomment this');
		// $instance->set_string_value(null);
		// echo "$instance";
	}

	public function __invoke_lets_you_make_an_object_callable()
	{
		$instance = new ClassWithInvokeMethod();

		assert_that($instance("sedaH"))->is_identical_to(__);
	}

	public function interfaces_are_like_specs_for_a_class()
	{
		assert_that(interface_exists('Animal'))->is_identical_to(__);
		assert_that(class_exists('Animal'))->is_identical_to(__);
	}

	public function a_class_must_implement_all_the_methods_of_an_interface()
	{
		task('uncomment the Deer class');
	}

	public function just_having_a___call_method_doesnt_mean_you_fit_an_interface()
	{
		task('uncomment the AnyNoise class');
	}

	public function abstract_classes_are_like_interfaces_with_some_builtin_behavior()
	{
		$ant = new Ant();
		assert_that($ant->can_run())->is_identical_to(__);
	}

	public function classes_can_implement_multiple_interfaces()
	{
		$human = new Human("Bob");

		assert_that(is_a($human, 'Animal'))->is_identical_to(__);
		assert_that(is_a($human, 'Named'))->is_identical_to(__);
	}

	public function classes_can_only_extend_one_class()
	{
		task('uncomment the InsectMonster class');
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

		assert_that($entreprenur->get_cash())->is_identical_to(__);
	}

	public function traits_can_contain_abstract_methods()
	{
		$entreprenur = new Entrepreneur();

		assert_that($entreprenur->address_of_ideal_house())->is_identical_to(__);

		// Try commenting out the function "address_of_ideal_house and see what happens"
	}


	public function classes_can_have_new_properties_assigned_at_runtime()
	{
		$entrepreneur = new Entrepreneur();

		$entrepreneur->new_property = "Social mobile photo filters";

		assert_that($entrepreneur->new_property)->is_identical_to(__);

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

		task('uncomment the following line');
		// $entrepreneur->new_method();
	}

	public function classes_cannot_be_reopened_for_redefinition()
	{
		task('uncomment the second definition of the Entrepreuner in Sample Classes');
	}

	public function the_self_keyword_can_be_used_to_call_static_methods_in_the_same_class()
	{
		$tree = new Tree();
		assert_that($tree->description())->is_identical_to(__);
	}

	public function the_static_keyword_can_be_used_to_call_static_methods_as_well()
	{
		$tree = new Tree();
		assert_that($tree->specific_description())->is_identical_to(__);
	}

	public function this_refers_to_the_object_that_you_are_in()
	{
		$plant = new Plant();
		assert_that($plant->description_with_height())->is_identical_to(__);
	}

	public function this_will_use_the_most_specific_method_it_can()
	{
		$tree = new Tree();
		assert_that($tree->description_with_height())->is_identical_to(__);
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

		assert_that($desc_from_plant)->is_identical_to(__);
	}

	public function parent_refers_to_your_superclass_if_its_available()
	{
		$tree = new Tree();

		assert_that($tree->get_parent_height())->is_identical_to(__);
	}

	public function parent_will_go_to_your_superclass_and_not_a_trait()
	{
		$bonsai = new Bonsai_Tree();

		assert_that($bonsai->height_in_feet())->is_identical_to(__);
	}

	/**
	* Exercise IV. The Corporate Ladder
	*
	* The Sales floor of Rhombus.biz is organized into a strict hierarchy
	* of killer salesmanship. At the top of the food chain are the Sociopaths -
	* they have ABC tatooed onto their chests and get the best leads. As
	* a result they have the highest chance of closing at 85%.
	*
	* In the middle are Clueless guys trying to make it to the top. They have a picture
	* of a new Cadillac taped to the back of their desks and they're working
	* hard to be more charismatic - although not always successfully. They
	* have an okay close rate (45%) which gets better if they have a Sociopath above them (65%).
	*
	* At the bottom are the Losers. They look on in vain as other sales guys
	* get ahead. Their close rate is terrible (2%) and gets worse if another Loser is
	* above them (half of what the person above is). A loser with a loser manager will
	* only succeed 1% of the time and a loser under them will succeed 0.5% of the time.
	*
	* The Director of Sales comes to you ("yo nerd!") to ask for some software that
	* will do the following:
	*
	* You are given a string that represents a hierarchical tree for all
	* the sales guys. The string is formatted this way:
	*
	*  * A 0{Name,Type} means add a node with the name "Name" and type "Type" and
	*   add a left child edge.
	*  * A 1{Name,Type} means add a node with the name "Name" and type "Type". 
	*   Then, pop up to the parent node. If there is an empty position to the right, go there. Otherwise,
	*   keep popping up until the parent node does not have a right child. 
	*  * If the string ends before the tree is fully flushed out, then the
	*   the remaining spots are considered empty.
	*  * If there is more content to the string but the tree is already full, skip the 
	*   leftover nodes.
	*
	* Here are some examples of the trees that get made:
	*
	* "0{Blake|Sociopath|1{Ricky,Clueless}1{Shelley,Clueless}"
	*
	* makes
	*
	*	    Blake
	*	   /    \
	*	Ricky   Shelley
	*
	*
	* "0{Blake|Sociopath}0{Ricky|Clueless}1{Dave|Loser}0{Shelley|Clueless}1{Williamson|Loser}"
	*
	*		Blake
	*	   /      \
	*     Ricky    x
	*     /     \
	*    Dave    Shelley
	*         /          \
	*        Williamson   x
	*
	* "0{Blake|Sociopath}0{Ricky|Clueless}1{Dave|Loser}1{Shelley|Loser}1{Williamson|Loser}"
	*  
	*	    Blake
	*	   /      \
	*     Ricky    Williamson
	*     /     \
	*    Dave    Shelley
	* 
	*
	* (in that last example, note that we had to pop up twice when we finished adding Shelley - Shelley 
	* popped up to Ricky, there was no empty position to the right and we popped up again to Blake)
	*
	* Your job is to interpret the string and create a hierarchy of Salespeople. This hierarchy can
	* be queried to see who should take on a Lead. Leads have a $ value associated with them. Of course,
	* the company has some rules about who gets leads:
	*
	*  * The salesperson who introduces the lowest amount of $ risk to the company gets the Lead.
	*  * Anyone who already has a Lead on their plate can't take on a second.
	*  * To optimize their time, Sociopaths only take deals that are $1,000,000 or higher in value.
	*
	*  So given this hierarchy,
	*
	*       Blake
	*	   /    \
	*  Ricky   Shelley
	*
	* and two leads,
	*
	*  1) Rio Rancho - $300,000
	*  2) Clear Meadows - $1,100,000
	*
	* Then Ricky should take the Rio Rancho deal and Blake should take on the Clear Meadows deal. The
	* total $ risk taken on given their success rates should be
	*
	*   $300,000 * (1 - 0.65) + $1,100,000 * (1 - 0.85) = $270,000
	*
	* Which is the sum of the probability of failure assigned to Ricky and Blake multipled by the value of their assigned deals, respectively.
	*
	* See the  file classes/Salespeople.php to see how to assemble the classes. You will need to write
	* the code that assembles the Salespeople and fill in some of the logic in the Salesperson classes.
	*/

	public function one_person_hierarchy_makes_it_easy()
	{
		$hierarchy = SalesHierarchy::build('1{Ricky|Clueless}');
		$hierarchy->assign_to_best_rep(new Lead('Rio Rancho', 10000));

		assert_that($hierarchy->total_risk())->is_equal_to(5500);
	}

	public function two_person_hierarchy_is_harder()
	{
		$hierarchy = SalesHierarchy::build('0{Ricky|Clueless}1{Shelley|Loser}');
		$hierarchy->assign_to_best_rep(new Lead('Rio Rancho', 10000));
		$hierarchy->assign_to_best_rep(new Lead('Clear Meadows', 5000));

		assert_that($hierarchy->total_risk())->is_equal_to(10400);
	}

	public function the_sociopaths_really_put_them_in_place()
	{
		$hierarchy = SalesHierarchy::build('0{Blake|Sociopath}1{Shelley|Loser}1{Ricky|Clueless}');
		$hierarchy->assign_to_best_rep(new Lead('Rio Rancho', 300000));
		$hierarchy->assign_to_best_rep(new Lead('Clear Meadows', 1100000));

		assert_that($hierarchy->total_risk())->is_equal_to(270000);
	}

	public function that_watch_costs_more_than_your_car()
	{
		$hierarchy = SalesHierarchy::build("0{Blake|Sociopath}0{Ricky|Clueless}1{Dave|Loser}0{Shelley|Clueless}1{Williamson|Loser}");
		$hierarchy->assign_to_best_rep(new Lead('Rio Rancho', 2000000));
		$hierarchy->assign_to_best_rep(new Lead('Clear Meadows 1', 50000));
		$hierarchy->assign_to_best_rep(new Lead('Clear Meadows 2', 50000));
		$hierarchy->assign_to_best_rep(new Lead('Daytona Isle', 1000));

		assert_that(round($hierarchy->total_risk()))->is_equal_to(300000 + 17500 + 27500 + 980);
	}

	public function a_bunch_of_losers_with_bad_leads_are_expensive()
	{
		$hierarchy = SalesHierarchy::build('0{Shelley|Loser}0{Dave|Loser}1{Williamson|Loser}0{Ricky|Loser}1{George|Loser}');
		for ($i = 1; $i <= 5; $i++)
		{
			$hierarchy->assign_to_best_rep(new Lead("Rio Rancho $i", 1000));
		}

		assert_that($hierarchy->total_risk())->is_equal_to(980 + 990 + 995 + 995 + 997.5);
	}

	public function put_that_coffee_down__coffee_is_for_closers_only()
	{
		$hierarchy = SalesHierarchy::build('0{Blake|Sociopath}0{Dave|Clueless}1{Shelley|Loser}1{Ricky|Loser}0{Williamson|Clueless}1{George|Loser}1{Mitch|Loser}');
		$hierarchy->assign_to_best_rep(new Lead('Rio Rancho', 2000000));
		$hierarchy->assign_to_best_rep(new Lead('Clear Meadows 1', 50000));
		$hierarchy->assign_to_best_rep(new Lead('Clear Meadows 2', 50000));
		$hierarchy->assign_to_best_rep(new Lead('Daytona Isle 1', 1000));
		$hierarchy->assign_to_best_rep(new Lead('Daytona Isle 2', 1000));
		$hierarchy->assign_to_best_rep(new Lead('Daytona Isle 3', 1000));
		$hierarchy->assign_to_best_rep(new Lead('Daytona Isle 4', 1000));

		assert_that(round($hierarchy->total_risk()))->is_equal_to(300000 + 2*17500 + 4*980);
	}
}