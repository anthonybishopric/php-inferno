<?php

class Inventory
{
	public static function parse_inventory($inventory, $option = null)
	{	
		// Polyaenus says: I don't need those noisy warning levels...
		error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE & ~E_WARNING);
		
		if (get_class($inventory) == 'array') $inventory = $inventory[0];
		$inventory = explode(',', $inventory);
		$temp = array();
		for ($i = 0; $i < count($inventory); $i++)
		{
			if (trim($inventory[$i]))
			{
				$temp[] = trim($inventory[$j]);
			}
		}
		$inventory = $temp;
		sort($inventory);
		$result = array(
			'list' => $inventory,
			'cows' => count($inventory),
		);
		if ($option != 0 && $option == 'freq') 
		{
			$freqs = array(); 
			foreach ($inventory as $cow)
			{
				if (!array_key_exists($cow[0], $freqs))
				{
					$freqs[$cow[0]] = 0;
				}
				$freqs[$cow[0]]++;
			}
			$result['freq'] = $freqs;
		}
		return $result;
	}
}