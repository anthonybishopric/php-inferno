<?php

class SalesHierarchy
{
	public static function build($sales_hierarchy_string)
	{
		// implement me!
		$root = null;
		$in_sales_definition = false;

		$in_context_of = [];
		$add_child = false;
		$inner = '';

		for ($string_index = 0; $string_index < strlen($sales_hierarchy_string); $string_index++)
		{
			$char = substr($sales_hierarchy_string, $string_index, 1);

			if (!$in_sales_definition)
			{
				if ($char === '{')
				{
					$in_sales_definition = true;
					continue;
				}
				else if (in_array($char, ['0', '1']))
				{
					$add_child = $char === '0';
					continue;
				}
			}
			else
			{
				if ($char === '}')
				{
					$in_sales_definition = false;
					$sales = explode('|', $inner);
					$inner = '';
					switch($sales[1])
					{
						case 'Sociopath':
						case 'Clueless':
						case 'Loser':
							$new_sales_guy = new $sales[1]();
							break;
						default:
							throw new Exception(sprintf("Can't recognize %s", $sales[1]));
					}
					if (!$root)
					{
						$root = $new_sales_guy;
					}
					else if ($in_context_of)
					{
						while ($in_context_of)
						{
							$current = $in_context_of[count($in_context_of) - 1];
							if (!$current->left())
							{
								$current->set_left($new_sales_guy);
								$new_sales_guy->set_parent($current);
								break;
							}
							if (!$current->right())
							{
								$current->set_right($new_sales_guy);
								$new_sales_guy->set_parent($current);
								break;
							}
							array_pop($in_context_of);
						}
					}

					if ($add_child)
					{
						$add_child = false;
						array_push($in_context_of, $new_sales_guy);
					}

				}
				else
				{
					$inner = $inner . $char;
				}
			}
		}
		return new SalesHierarchy($root);
	}

	private $root;

	public function __construct(Salesperson $root)
	{
		$this->root = $root;
	}

	public function assign_to_best_rep(Lead $lead)
	{
		$rep = $this->root->get_best_sales_rep($lead);
		$rep->set_current_lead($lead);
	}

	public function total_risk()
	{
		return $this->root->total_risk_incurred();
	}
}

abstract class Salesperson
{
	/**
	* @var Salesperson
	*/
	protected $parent = null;

	/**
	* @var Salesperson
	*/
	protected $right = null;

	/**
	* @var Salesperson
	*/
	protected $left = null;

	/**
	* @var Salesperson
	*/
	private $current_lead = null;

	public function parent()
	{
		return $this->parent;
	}


	public function left()
	{
		return $this->left;
	}

	public function right()
	{
		return $this->right;
	}

	public function set_right(Salesperson $person)
	{
		$this->right = $person;
	}

	public function set_left(Salesperson $person)
	{
		$this->left = $person;
	}

	public function set_parent(Salesperson $person)
	{
		$this->parent = $person;
	}

	public function set_current_lead(Lead $lead)
	{
		$this->current_lead = $lead;
	}

	/**
	* @return double a value between 0 and 1 that represents the
	* rate of success this salesperson has with deals.
	*/
	protected abstract function success_rate();

	protected function can_take_lead(Lead $lead)
	{
		// tip: you may want to override this function in one of the subclasses.
		return true;
	}

	public function get_best_sales_rep(Lead $lead, Salesperson $winner_so_far = null)
	{
		// implement me!

		if ($this->can_take_lead($lead) && $this->current_lead == null)
		{
			if ($winner_so_far == null || ($this->risk($lead) < $winner_so_far->risk($lead)))
			{
				$winner_so_far = $this;
			}
		}

		if ($this->left)
		{
			$winner_so_far = $this->left->get_best_sales_rep($lead, $winner_so_far);
		}
		if ($this->right)
		{
			$winner_so_far = $this->right->get_best_sales_rep($lead, $winner_so_far);
		}

		return $winner_so_far;
	}

	public function total_risk_incurred()
	{
		$total = 0;
		if ($this->current_lead)
		{
			$total += $this->risk($this->current_lead);
		}
		if ($this->left)
		{
			$total += $this->left->total_risk_incurred();
		}
		if ($this->right)
		{
			$total += $this->right->total_risk_incurred();
		}
		return $total;
	}

	/**
	* @return calculates the risk that the company takes on given
	* the #{success_rate()} of the Salesperson
	*/
	public function risk(Lead $lead)
	{
		return $lead->value() * (1 - $this->success_rate());
	}

	public function __toString()
	{
		return $this->stringer(0);
	}

	private function stringer($indent_level)
	{
		$name = str_repeat('-', $indent_level) . get_class($this) . " (has lead? " .( $this->current_lead ? $this->current_lead->value() : 'no'). ") \n";
		if ($this->left)
		{
			$name .= $this->left->stringer($indent_level + 1);
		}
		if ($this->right)
		{
			$name .= $this->right->stringer($indent_level + 1);
		}
		return $name;
	}
}

class Sociopath extends Salesperson
{
	public function success_rate()
	{
		// implement me!
		return 0.85;
	}

	public function can_take_lead(Lead $lead)
	{
		return $lead->value() >= 1000000;
	}
}

class Clueless extends Salesperson
{
	public function success_rate()
	{
		// implement me!

		// tip: use the is_a function

		if (is_a($this->parent, 'Sociopath'))
		{
			return 0.65;
		}
		return 0.45;
	}
}

class Loser extends Salesperson
{
	public function success_rate()
	{
		// implement me!

		if (is_a($this->parent, 'Loser'))
		{
			return $this->parent->success_rate() / 2;
		}
		return 0.02;
	}
}

class Lead
{
	private $name;
	private $value;

	public function __construct($name, $value)
	{
		$this->name = $name;
		$this->value = $value;
	}

	public function value()
	{
		return $this->value;
	}
}