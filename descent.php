<?php

echo "\033[31m";
?>
Abandon hope, all ye who enter here...

.########.##.....##.########....####.##....##.########.########.########..##....##..#######.
....##....##.....##.##...........##..###...##.##.......##.......##.....##.###...##.##.....##
....##....##.....##.##...........##..####..##.##.......##.......##.....##.####..##.##.....##
....##....#########.######.......##..##.##.##.######...######...########..##.##.##.##.....##
....##....##.....##.##...........##..##..####.##.......##.......##...##...##..####.##.....##
....##....##.....##.##...........##..##...###.##.......##.......##....##..##...###.##.....##
....##....##.....##.########....####.##....##.##.......########.##.....##.##....##..#######.

<?php
echo "\033[0m";
error_reporting(E_ALL);

$min_version = '5.4.9';
if (version_compare($min_version, phpversion()) > 0)
{
	trigger_error("You must have PHP $min_version or greater installed to enter the Inferno. Check the README for instructions.", E_USER_ERROR);
}

require_once 'Pathway_Through_Darkness.php';

$pathway = new Pathway_Through_Darkness([
	'Limbo',
	'Lust',
	'Gluttony',
	'Greed',
	'Anger',
	'Heresy',
	'Violence',
	'Fraud',
	'Treachery'
]);

$pathway->descend();