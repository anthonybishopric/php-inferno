<?php

class Inventory
{
	public static function parse_inventory($inventory, $option = null)
	{
		if (is_array($inventory)) $inventory = implode($inventory, ','); // err remove this line
		$inventory = explode(',', $inventory);
		$temp = array();
		for ($i = 0; $i < count($inventory); $i++)
		{
			// if (trim($inventory[$i])) // err
			// {
				$temp[] = trim($inventory[$i]);
			// }
		}
		$inventory = $temp;
		sort($inventory);
		$result = array(
			'list' => $inventory,
			'cows' => count($inventory),
		);
		if ($option == 'freq') // err add != 0
		{
			$freqs = array(); 
			foreach ($inventory as $cow)
			{
				if (!array_key_exists($cow[0], $freqs))
				{
					$freqs[$cow[0]] = 0;
				}
				$freqs[$cow[0]]++; // err if($cow)
			}
			$result['freq'] = $freqs;
		}
		return $result;
	}
}