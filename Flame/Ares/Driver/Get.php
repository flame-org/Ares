<?php

namespace Flame\Ares\Driver;

use Nette\Object;

/**
 * Description of Get
 *
 * @author Milan Matějček
 */
class Get extends Object implements IRequest {

    const URL = 'http://wwwinfo.mfcr.cz/cgi-bin/ares/darv_bas.cgi?ico=';

    /** @var Data */
    protected $data;
    protected $IN;

    public function __construct(Data $data = NULL) {
        $this->data = $data ? $data : new Data;
    }

    public function loadData($inn = NULL) {
        if ($inn === NULL) {
            return $this->data;
        }

        return $this->loadXML($inn);
    }

    private function loadXML($inn) {
        $this->setIN($inn);
        $curl = new \h4kuna\CUrl(self::URL . $this->IN);
        $xmlSource = $curl->exec();
        if ($xmlSource) {
            $xml = @simplexml_load_string($xmlSource);
            if (!$xml) {
                throw new \Flame\Ares\AresException('No response.', 404);
            }
        } else {
            $curl->getErrors();
        }

        $ns = $xml->getDocNamespaces();
        $el = $xml->children($ns['are'])->children($ns['D'])->VBAS;

        if (!isset($el->ICO)) {
            return $this->data;
        }

        $street = strval($el->AD->UC);
        if (is_numeric($street)) {
            $street = $el->AA->NCO . ' ' . $street;
        }

        if (isset($el->AA->CO)) {
            $street .= '/' . $el->AA->CO;
        }

        $this->data
	        ->setIN($el->ICO)
            ->setTIN($el->DIC)
            ->setCity($el->AA->N)
            ->setCompany($el->OF)
            ->setStreet($street)
	        ->setPerson($el->PF->KPF)
            ->setCreated($el->DV)
            ->setZip($el->AA->PSC);

        if (isset($el->ROR)) {
            $this->data->setActive($el->ROR->SOR->SSU)
                    ->setFileNumber($el->ROR->SZ->OV)
                    ->setCourt($el->ROR->SZ->SD->T);
        }

        return $this->data;
    }

    private function setIN($inn) {
        $this->IN = new \h4kuna\Int($inn);
        if (!preg_match('~^\d{6,9}$~', $this->IN->getValue())) {
            throw new \Flame\Ares\AresException('IN must be a number');
        }
        return TRUE;
    }

    public function clean() {
        $this->data->clean();
        return $this;
    }

}

