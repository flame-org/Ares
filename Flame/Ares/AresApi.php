<?php

namespace Flame\Ares;

use Nette\Object;

/**
 * @author Milan Matějček <milan.matejcek@gmail.com>
 *
 * @example
  $ares = new Ares;
  var_dump($ares->loadData('87744473'));
 */
class AresApi extends Object
{

	/** @var \Flame\Ares\Driver\DriverFactory */
	private $driverFactory;

	/**
	 * @param Driver\DriverFactory $factory
	 */
	public function __construct(\Flame\Ares\Driver\DriverFactory $factory) {
        $this->driverFactory = $factory;
    }

	/**
	 * @param $inn
	 * @return Driver\Data|object
	 */
	public function loadData($inn)
    {
	    $driver = $this->driverFactory->getDriver($inn);
        return $driver->loadData($inn);
    }

}

class AresException extends \RuntimeException {

}
