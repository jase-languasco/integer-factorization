<?php

class prime_factors {

	private $number;
	private $verified = false;
	private $prime_factors = [];
	private $prime_numbers = [];

	public function __construct($number) {
		$this->number = $number;
		$this->verify_number();

		if ($this->verify_number()) {
			$this->build_prime_numbers();
			$this->integer_factorization();
		}
	}

	private function verify_number() {

		//we will not run if the number is zero or is not an integer
		if (!is_int($this->number) || $this->number == 0) return 'Your entry was invalid. You either entered zero or not a valid number';

		//we will start at 3 because all numbers are divisiable by 1, except for zero of course, and we do not want to divide by it's self because we will get 1, once again except for zero.

		if ($this->number % 2 == 0 && $this->number != 2) return true;
		else {
			for ($i = 3; $i < $this->number; $i++) {
				if ($this->number % $i == 0) {
					return false;
				}
			}
		}
	}

	private function build_prime_numbers() {
		//we can start at 2 -- we know that's a prime, but that's the only one I'm giving you! (This also saves us two useless iterations per number)
		$prime_number_ceiling = $this->number;
		for ($i = 2; $i < $prime_number_ceiling; $i++) {
			$is_prime = true;
			for ($z = 2; $z < $i; $z++) {
				$solution = $i / $z;
				if (floor($solution) == $solution) $is_prime = false;
			}
			if ($is_prime == true) $this->prime_numbers[] = $i;
		}
	}

	public function integer_factorization() {
		if (!empty($this->prime_numbers)) {

			foreach ($this->prime_numbers as $prime) {
				if ($this->number % $prime == 0) {
					$testable_quotient = $factor = $quotient = $this->number/$prime;
					$this->prime_factors[] = $prime;
					if (in_array($quotient, $this->prime_numbers)) {
						$this->prime_factors[] = $quotient;
						return;
					}
					break;
				}
			}
			unset($prime);

			while ($testable_quotient > 1) {
				foreach ($this->prime_numbers as $prime) {
					$quotient = $factor / $prime;
					if ($factor % $prime == 0) {
						$testable_quotient = $factor = $quotient;
						$this->prime_factors[] = $prime;
					}
				}
			}
		}
	}

	public function get_prime_factors() {
		if (!empty($this->prime_factors)) {
			$this->test_prime_factors();
			$prime_print_string = $this->number . ' = ';

			foreach ($this->prime_factors as $prime_factor) $prime_print_string .= $prime_factor . ' * ';

			$prime_print_string = rtrim($prime_print_string, ' * ');
			return $prime_print_string;
		}
		else return false;
	}

	private function test_prime_factors() {
		foreach ($this->prime_factors as $prime_factor) {
			if (!empty($quotient)) $quotient *= $prime_factor;
			else $quotient = $prime_factor;
		}
		if ($quotient != $this->number) echo 'Did not pass test! Check the code!';
	}

}


//back-to-back tests
function run_test ($num_test) {
	$starttime = microtime(true);
	if (empty($num_test)) $num_test = 10;
	$test = [];
	for ($i = 0; $i <= $num_test; $i++) {
		echo $i.' -- ';
		$test[$i] = new prime_factors($i);
		$test[$i]->integer_factorization();
		echo $test[$i]->get_prime_factors();
		echo '<br><br>';
	}
	$endtime = microtime(true);
	$runtime = $endtime - $starttime;
	echo 'Run Time: '.$runtime;
}

//one test
function speed_test ($number) {
	$starttime = microtime(true);
	$test = new prime_factors($number);
	echo $test->get_prime_factors();
	$endtime = microtime(true);
	$runtime = $endtime - $starttime;
	echo '<br><br>Run Time: '.$runtime;
}

//run_test(1500);
speed_test(10000);

?>
