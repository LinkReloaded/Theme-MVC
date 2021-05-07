<?php
/**
 * Constants to define the accuracy in numeric aproximations, and the max
 * iterations to solve
 */
define('FINANCIAL_ACCURACY', 1.0e-6);
define('FINANCIAL_MAX_ITERATIONS', 100);


class Financial
{
	function Financial()
	{
		// forces the precision for calculations
		ini_set('precision', '14');
	}
	
	/**
	 * NPV
	 * Calculates the net present value of an investment by using a
	 * discount rate and a series of future payments (negative values)
	 * and income (positive values).
	 * 
	 *        n   /   values(i)  \
	 * NPV = SUM | -------------- |
	 *       i=1 |            i   |
	 *            \  (1 + rate)  /
	 * 
	 **/
	function NPV($rate, $values)
	{
		if (!is_array($values)) return null;
		
		$npv = 0.0;
		for ($i = 0; $i < count($values); $i++)
		{
			$npv += $values[$i] / pow(1 + $rate, $i + 1);
		}
		return (is_finite($npv) ? $npv: null);
	}
	
	
	/*
	 * IRR
	 * Returns the internal rate of return for a series of cash flows
	 * represented by the numbers in values. These cash flows do not
	 * have to be even, as they would be for an annuity. However, the
	 * cash flows must occur at regular intervals, such as monthly or
	 * annually. The internal rate of return is the interest rate
	 * received for an investment consisting of payments (negative
	 * values) and income (positive values) that occur at regular periods.
	 * 
	 */
	function IRR($values, $guess = 0.1)
	{
		if (!is_array($values)) return null;
		
		// create an initial bracket, with a root somewhere between bot and top
		$x1 = 0.0;
		$x2 = $guess;
		$f1 = $this->NPV($x1, $values);
		$f2 = $this->NPV($x2, $values);
		for ($i = 0; $i < FINANCIAL_MAX_ITERATIONS; $i++)
		{
			if (($f1 * $f2) < 0.0) break;
			if (abs($f1) < abs($f2)) {
				$f1 = $this->NPV($x1 += 1.6 * ($x1 - $x2), $values);
			} else {
				$f2 = $this->NPV($x2 += 1.6 * ($x2 - $x1), $values);
			}
		}
		if (($f1 * $f2) > 0.0) return null;
		
		$f = $this->NPV($x1, $values);
		if ($f < 0.0) {
			$rtb = $x1;
			$dx = $x2 - $x1;
		} else {
			$rtb = $x2;
			$dx = $x1 - $x2;
		}
		
		for ($i = 0;  $i < FINANCIAL_MAX_ITERATIONS; $i++)
		{
			$dx *= 0.5;
			$x_mid = $rtb + $dx;
			$f_mid = $this->NPV($x_mid, $values);
			if ($f_mid <= 0.0) $rtb = $x_mid;
			if ((abs($f_mid) < FINANCIAL_ACCURACY) || (abs($dx) < FINANCIAL_ACCURACY)) return $x_mid;
		}
		return null;
	}
	
	
}

?>