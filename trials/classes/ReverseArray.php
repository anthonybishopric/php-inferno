<?php

class ReverseArray implements ArrayAccess
{
	private $start_index = 0;
	private $internal_array = [];

	/**
	* @param uint $starting_index the starting point for the
	* array. All accesses to the ReverseArray are calculated as
	*
	*
	*  $internal_array[$starting_index - $target]
	*
	* where $target is the index being requested.
	*/
	public function __construct($starting_index)
	{
		$this->start_index = $starting_index;
	}

	public function offsetExists($offset)
	{
		return array_key_exists($this->start_index - $offset, $this->internal_array);
	}

	public function offsetGet($offset)
	{
		// implement me!

		throw new BadMethodCallException('implement this method');
	}

	public function offsetSet($offset, $value)
	{
		// implement me!
		
		throw new BadMethodCallException('implement this method');
	}

	public function offsetUnset($offset)
	{
		unset($this->internal_array[$this->start_index - $offset]);
	}
	
	public function getInternalArray()
	{
		return $this->internal_array;
	}
}