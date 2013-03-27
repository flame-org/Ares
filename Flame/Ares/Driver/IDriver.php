<?php

namespace Flame\Ares\Driver;

/**
 * Description of IRequest
 *
 * @author Milan Matějček
 */
interface IDriver {

	/**
	 * @param string $in
	 * @return \Flame\Ares\Types\Data
	 */
	public function loadData($in);

	/**
	 * Return url service
	 * @param $key
	 * @return string
	 */
	public function getRequestUrl($key);
}

