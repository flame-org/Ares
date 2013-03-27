<?php
/**
 * InDriver.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    27.03.13
 */

namespace Flame\Ares\Driver;

class InDriver extends Driver
{

	/**
	 * @param string $inn
	 * @return Data|object
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
		$url->setQuery(array('ico' => $key));
		return (string) $url;
	}
}
