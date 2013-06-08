<?php

class CreditRating implements Countable
{
	private $credit_rating = null;

	public function set_credit_rating($credit_rating)
	{
		$this->credit_rating = $credit_rating;
	}

	public function count()
	{
		if ($this->credit_rating === null)
		{
			return 0;
		}
		return strlen($this->credit_rating);
	}
}

class StringIterator implements Iterator
{
	private $index = 0;
	private $string = null;

	public function __construct($string)
	{
		$this->string = $string;
	}

	public function current()
	{
		return $this->string[$this->index];
	}

	public function next()
	{
		$this->index++;
	}

	public function valid()
	{
		return strlen($this->string) > $this->index;
	}

	public function key()
	{
		return $this->index;
	}

	public function rewind()
	{
		$this->index = 0;
	}
}

class NumberRange implements JsonSerializable
{
	private $start = null;
	private $end = null;
	
	public function __construct($start, $end) 
	{
		$this->start = $start;
		$this->end = $end;
	}
	
	public function jsonSerialize()
	{
		return range($this->start, $this->end);
	}
}