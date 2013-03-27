<?php
/**
 * Driver.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    27.03.13
 */

namespace Flame\Ares\Driver;

abstract class Driver extends \Nette\Object implements IDriver
{

	/**
	 * @param $url
	 * @return string
	 * @throws \Flame\Ares\AresException
	 */
	public function getRequestResponse($url)
	{
		try {
			$conn = new \Kdyby\Curl\Request($url);
			return $conn->get()->getResponse();
		} catch (\Kdyby\Curl\CurlException $ex) {
			throw new \Flame\Ares\AresException($ex->getMessage());
		}
	}

	/**
	 * @param $xmlSource
	 * @return Data
	 */
	public function loadXML($xmlSource)
	{
		$xml = $this->parseXml($xmlSource);

		$ns = $xml->getDocNamespaces();
		$el = $xml->children($ns['are'])->children($ns['D'])->VBAS;

		$data = new \Flame\Ares\Types\Data;

		if (!isset($el->ICO))
			return $data;

		$street = strval($el->AD->UC);
		if (is_numeric($street)) {
			$street = $el->AA->NCO . ' ' . $street;
		}

		if (isset($el->AA->CO)) {
			$street .= '/' . $el->AA->CO;
		}

		$data->setIN($el->ICO)
			->setTIN($el->DIC)
			->setCity($el->AA->N)
			->setCompany($el->OF)
			->setStreet($street)
			->setPerson($el->PF->KPF)
			->setCreated($el->DV)
			->setZip($el->AA->PSC);

		if (isset($el->ROR)) {
			$data->setActive($el->ROR->SOR->SSU)
				->setFileNumber($el->ROR->SZ->OV)
				->setCourt($el->ROR->SZ->SD->T);
		}

		return $data;
	}

	/**
	 * @param $xmlString
	 * @return object
	 * @throws \Flame\Ares\AresException
	 */
	protected function parseXml($xmlString)
	{
		$xml = @simplexml_load_string($xmlString);

		if (!$xml)
			throw new \Flame\Ares\AresException('No response.', 404);

		return $xml;
	}

}
