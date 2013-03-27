<?php
/**
 * NameDriver.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    27.03.13
 */

namespace Flame\Ares\Drives;

class NameDriver extends \Flame\Ares\Driver\Driver
{

	/**
	 * @param string $inn
	 * @return Data
	 */
	public function loadData($inn)
	{
		$url = $this->getRequestUrl($inn);
		$response = $this->getRequestResponse($url);
		return $this->loadXML($response);
	}

	/**
	 * @param $key
	 * @return string
	 */
	public function getRequestUrl($key)
	{
		$url = new \Nette\Http\Url(self::URL);
		$url->setQuery(array('obchodni_firma' => urlencode($key)));
		return (string) $url;
	}

}
