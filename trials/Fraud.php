<?php

require 'classes/SPLClasses.php';

/**
* SPL
*/
class Fraud
{
	public function the_standard_php_library_comes_with_many_special_classes()
	{
		$array = new SplFixedArray(3);
		$array[0] = 'Flattery';
		$array[1] = 'Seduction';
		$array[2] = 'Simony';

		try
		{
			$array[3] = 'Sorcery';
		}
		catch (RuntimeException $e)
		{

		}

		assert_that(count($array))->is_identical_to(3);
		assert_that(get_class($e))->is_identical_to('RuntimeException');
		assert_that($e->getMessage())->contains_string('invalid or out of range');

	}

	public function spl_arrays_do_not_allow_string_indices()
	{
		$array = new SplFixedArray(1);
		try
		{
			$result = $array['Jason'];
		}
		catch (RuntimeException $e)
		{

		}

		assert_that(isset($result))->is_identical_to(false);
		assert_that($e->getMessage())->contains_string('invalid or out of range');
	}

	public function spl_min_and_max_heaps_are_available_to_do_sort_operations()
	{
		$max_heap = new SplMinHeap();
		$max_heap->insert(5);
		$max_heap->insert(10);
		$max_heap->insert(2);
		$max_heap->insert(20);

		$result = [];
		foreach($max_heap as $value)
		{
			$result[] = $value;
		}

		assert_that($result)->is_identical_to([2, 5, 10, 20]);
	}

	public function spl_object_storage_can_be_used_like_a_set()
	{
		$spl_storage = new SplObjectStorage();

		$an_object = new ClassWithProperties();

		$spl_storage->attach($an_object);
		$spl_storage->attach($an_object);

		assert_that(count($spl_storage))->is_identical_to(1);
	}

	public function spl_priority_queue_is_useful_for_custom_priorities()
	{
		$priority_queue = new SplPriorityQueue();
		$priority_queue->insert('o', 1);
		$priority_queue->insert('i', 3);
		$priority_queue->insert('S', 4);
		$priority_queue->insert('n', 0);
		$priority_queue->insert('m', 2);

		$result = [];
		foreach($priority_queue as $value)
		{
			$result[] = $value;
		}

		assert_that(implode($result))->is_identical_to('Simon');
	}

	public function classes_that_implement_countable_get_the_count_function_for_free()
	{
		// see classes/SPLClasses.php

		$credit_rating = new CreditRating();
		$credit_rating->set_credit_rating('AAA');

		assert_that(count($credit_rating))->is_identical_to(3);
	}

	public function classes_that_implement_traversable_can_be_iterated_over()
	{
		// Virgil says: Traversable can't be implemented directly, user code must
		// implement Iterator or IteratorAggregate.

		$traverser = new StringIterator("Guido");

		$result = [];
		foreach ($traverser as $char)
		{
			$result[] = $char;
		}
		assert_that($result)->is_identical_to(['G', 'u', 'i', 'd', 'o']);
	}

	public function the_filter_iterator_allows_callbacks_to_remove_entries()
	{
		$traverser = new CallbackFilterIterator(new StringIterator('Guido'), function($el)
		{
			return $el > 'j';
		});

		$result = [];
		foreach ($traverser as $char)
		{
			$result[] = $char;
		}
		assert_that($result)->is_identical_to(['u', 'o']);
	}

	public function regex_iterator_filters_by_regex()
	{
		$names = ['Simon Magus', 'Pope Boniface', 'Pope Clement'];

		$regex_iterator = new RegexIterator(new ArrayIterator($names), '/^Pope.*/');

		$results = [];

		foreach ($regex_iterator as $person)
		{
			$results[] = $person;
		}

		assert_that($results)->is_identical_to(['Pope Boniface', 'Pope Clement']);
	}

	public function the_append_iterator_lets_you_combine_multiple_iterators_together()
	{
		$traverser = new AppendIterator();
		$traverser->append(new StringIterator('Ciampolo'));
		$traverser->append(new StringIterator('Caiaphas'));

		$result = [];
		foreach ($traverser as $char)
		{
			$result[] = $char;
		}
		assert_that(implode($result))->is_identical_to('CiampoloCaiaphas');

		// Virgil says: there are many more built-in iterators than this one, including
		// CachingIterator, InfiniteIterator, FilesystemIterator and others.
		// http://www.php.net/manual/en/spl.iterators.php

	}

	public function spl_autoload_register_will_let_you_add_a_callable_to_automatically_locate_classes()
	{
		assert_that(class_exists('Manto'))->is_identical_to(false);

		$loading_function = function($classname)
		{
			require_once 'classes/AutoloadedClass.php';
		};
		spl_autoload_register($loading_function);

		assert_that(class_exists('Manto'))->is_identical_to(true);

		$manto = new Manto();
		assert_that($manto->daugher_of())->is_identical_to('Tiresias');
	}

	public function objects_that_implement_the_JsonSerializable_interface_have_a_custom_json_encode()
	{
		// NumberRange is defined in classes/SPLClasses.php

		$number_range = new NumberRange(1, 10);
		assert_that(json_encode($number_range))->is_identical_to('[1,2,3,4,5,6,7,8,9,10]');
	}

}