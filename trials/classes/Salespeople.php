<?php

/**
* Things to implement in this file:
* - SalesHiearchy::build()
* - Salesperson::get_best_sales_rep()
* - The success_rate() method in each Salesperson subclass
*/

/**
* An accessor object to add leads to a sales hierarchy optimally and
* inspect the total amount of risk currently being taken on.
*/
class SalesHierarchy
{
	/**
	* Given the legacy salesperson hierarchy format, this returns
	* a hierarchy object that matches. See Greed.php for the specification.
	* @param string - the sales hierarchy
	* @return SalesHierarchy
	*/
	public static function build($sales_hierarchy_string)
	{
		// implement me!
		throw new BadMethodCallException('implement this method');
	}

	/**
	* @var Salesperson - the top sales guy, who runs everyone.
	*/
	private $root;

	/**
	* @param Salesperson 
	*/
	public function __construct(Salesperson $root)
	{
		$this->root = $root;
	}

	/**
	* @param Lead - a sales lead
	* @return void - the lead should be assigned to one of the Salespeople
	* in the SalesHierarchy. 
	*/
	public function assign_to_best_rep(Lead $lead)
	{
		$rep = $this->root->get_best_sales_rep($lead);
		$rep->set_current_lead($lead);
	}

	/**
	* @return float - the total risk incurred by the company given the distribution
	* of sales leads to salespeople.
	*/
	public function total_risk()
	{
		return $this->root->total_risk_incurred();
	}
}

/**
* A Salesperson abstract class. Concerete subclasses are below.
*/
abstract class Salesperson
{
	/**
	* @var Salesperson - the direct manager of this Salesperson
	*/
	protected $parent = null;

	/**
	* @var Salesperson - one of the two reports to this Salesperson
	*/
	protected $right = null;

	/**
	* @var Salesperson - one of the two reports to this Salesperson
	*/
	protected $left = null;

	/**
	* @var Salesperson - the current sales lead this Salesperson is working on
	* (note: this is a potential deal for the company, not the person's manager)
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

		throw new BadMethodCallException('implement this method');
	}

	/**
	* Sums the total risk incurred by this sales rep and the reps below.
	* @return float - the total risk incurred.
	*/
	public function total_risk_incurred()
	{
		$total = 0.0;
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
	* @return float - the risk that the company takes on given
	* the success_rate() of the Salesperson
	*/
	public function risk(Lead $lead)
	{
		return $lead->value() * (1 - $this->success_rate());
	}
}

class Sociopath extends Salesperson
{
	public function success_rate()
	{
		// implement me!
		throw new BadMethodCallException('implement this method');
	}
}

class Clueless extends Salesperson
{
	public function success_rate()
	{
		// implement me!

		// tip: use the is_a function

		throw new BadMethodCallException('implement this method');
	}
}

class Loser extends Salesperson
{
	public function success_rate()
	{
		// implement me!
		throw new BadMethodCallException('implement this method');
	}
}

/**
* An object to represent sales leads (as in, deals that have yet to come in, not
* a salesperson's manager). Gives the name and $ value of the lead.
*/
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