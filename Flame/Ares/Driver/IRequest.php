<?php

namespace Flame\Ares\Driver;

/**
 * Description of IRequest
 *
 * @author Milan Matějček
 */
interface IRequest {

    /**
     * @param string $in Identification Number
     * @return Data
     */
    public function loadData($in = NULL);

    /**
     * clean last request
     * @void
     */
    public function clean();
}

