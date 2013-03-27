<?php
/**
 * DriverFactory.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    27.03.13
 */

namespace Flame\Ares\Driver;

class DriverFactory extends \Nette\Object
{

	/** @var \Flame\Ares\Types\IdentificationNumber */
	private $number;

	/**
	 * @param \Flame\Ares\Types\IdentificationNumber $identificationNumber
	 */
	public function __construct(\Flame\Ares\Types\IdentificationNumber $identificationNumber)
	{
		$this->number = $identificationNumber;
	}

	/**
	 * @param $key
	 * @return InDriver|NameDriver
	 */
	public function getDriver($key)
	{
		if($this->number->verify($key)){
			return new \Flame\Ares\Drives\InDriver;
		}else{
			return new \Flame\Ares\Drives\NameDriver;
		}
	}

}
