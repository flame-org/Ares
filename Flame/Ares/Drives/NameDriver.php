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

	const URL = 'http://wwwinfo.mfcr.cz/cgi-bin/ares/darv_std.cgi';

	/**
	 * @param string $inn
	 * @return array|\Flame\Ares\Types\Data
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

	/**
	 * @param $xmlString
	 * @return array
	 */
	private function loadXML($xmlString)
	{
		$xml = $this->parseXml($xmlString);
		$ns = $xml->getDocNamespaces();

		$data = array();
		$el = $xml->children($ns['are'])->Odpoved;
		foreach($el->Zaznam as $item){
			$data[] = $this->getData($item);
		}

		return $data;
	}

}
