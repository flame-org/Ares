<?php
/**
 * NameDriver.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    27.03.13
 */

namespace Flame\Ares\Driver;

class NameDriver extends Driver
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
		$url->setQuery(array('obchodni_firma' => $key));
		return (string) $url;
	}

}
