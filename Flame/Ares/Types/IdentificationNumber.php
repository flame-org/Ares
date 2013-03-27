<?php
/**
 * In.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    27.03.13
 */

namespace Flame\Ares\Types;

class IdentificationNumber extends \Nette\Object
{

	/** @var string */
	private $string;

	/**
	 * @param null $string
	 */
	public function __construct($string = null)
	{
		$this->string = (string) $string;
	}

	/**
	 * @param null $string
	 * @return bool
	 */
	public function verify($string = null)
	{
		if($string !== null)
			$this->string = (string) $string;

		// "be liberal in what you receive"
		$key = preg_replace('#\s+#', '', $this->string);

		if($this->isCorrectString()){
			// kontrolní součet
			$a = 0;
			for ($i = 0; $i < 7; $i++) {
				$a += $key[$i] * (8 - $i);
			}

			$a = $a % 11;

			if ($a === 0) $c = 1;
			elseif ($a === 10) $c = 1;
			elseif ($a === 1) $c = 0;
			else $c = 11 - $a;

			return (int) $key[7] === $c;
		}

		return false;
	}

	/**
	 * @return bool
	 */
	private function isCorrectString()
	{
		if (!preg_match('#^\d{8}$#', $this->string))
			return false;

		return true;
	}

}
