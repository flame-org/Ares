<?php

namespace Flame\Ares\Driver;

/**
 * Description of IRequest
 *
 * @author Milan Matějček
 */
interface IDriver {

    /**
     * @param string $in Identification Number
     * @return Data
     */
    public function loadData($in);

	/**
	 * Return url service
	 * @param $key
	 * @return string
	 */
	public function getRequestUrl($key);
}

