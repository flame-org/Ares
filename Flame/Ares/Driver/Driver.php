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
	 * @param $xmlEl
	 * @return \Flame\Ares\Types\Data
	 */
	protected function getData($xmlEl)
	{
		$data = new \Flame\Ares\Types\Data;

		if (!isset($xmlEl->ICO))
			return $data;

		$street = strval($xmlEl->AD->UC);
		if (is_numeric($street)) {
			$street = $xmlEl->AA->NCO . ' ' . $street;
		}

		if (isset($xmlEl->AA->CO)) {
			$street .= '/' . $xmlEl->AA->CO;
		}

		$data->setIN($xmlEl->ICO)
			->setTIN($xmlEl->DIC)
			->setCity($xmlEl->AA->N)
			->setCompany($xmlEl->OF)
			->setStreet($street)
			->setPerson($xmlEl->PF->KPF)
			->setCreated($xmlEl->DV)
			->setZip($xmlEl->AA->PSC);

		if (isset($xmlEl->ROR)) {
			$data->setActive($xmlEl->ROR->SOR->SSU)
				->setFileNumber($xmlEl->ROR->SZ->OV)
				->setCourt($xmlEl->ROR->SZ->SD->T);
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
