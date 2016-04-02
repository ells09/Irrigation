<?php
/**
 * Created by PhpStorm.
 * User: inkre1
 * Date: 15-06-11
 * Time: 08:22
 */

/**
 * Re-maps a number from one range to another. That is, a value of fromLow would get mapped to toLow, a value of fromHigh to toHigh, values in-between to values in-between, etc.
 * Does not constrain values to within the range, because out-of-range values are sometimes intended and useful. The constrain() function may be used either before or after this function, if limits to the ranges are desired.
 * Note that the "lower bounds" of either range may be larger or smaller than the "upper bounds" so the map() function may be used to reverse a range of numbers, for example
 * y = map(x, 1, 50, 50, 1);
 * The function also handles negative numbers well, so that this example
 * y = map(x, 1, 50, 50, -100);
 * is also valid and works well.
 *
 * @param $x the number to map
 * @param $in_min the lower bound of the value's current range
 * @param $in_max the upper bound of the value's current range
 * @param $out_min the lower bound of the value's target range
 * @param $out_max the upper bound of the value's target range
 * @return float
 */

function map($x, $in_min, $in_max, $out_min, $out_max)
{
    return ($x - $in_min) * ($out_max - $out_min) / ($in_max - $in_min) + $out_min;
}