<?php
/**
 * InDriver.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    27.03.13
 */

namespace Flame\Ares\Drives;

class InDriver extends \Flame\Ares\Driver\Driver
{

	const URL = 'http://wwwinfo.mfcr.cz/cgi-bin/ares/darv_bas.cgi';

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

	/**
	 * @param $xmlSource
	 * @return Data
	 */
	private function loadXML($xmlSource)
	{
		$xml = $this->parseXml($xmlSource);
		$ns = $xml->getDocNamespaces();
		$el = $xml->children($ns['are'])->children($ns['D'])->VBAS;
		return $this->getData($el);
	}
}
