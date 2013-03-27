<?php

namespace Flame\Ares;

use Nette\Object;

/**
 * @author Milan Matějček <milan.matejcek@gmail.com>
 *
 * @example
  $ares = new Ares;
  var_dump($ares->loadData('87744473'));
 */
class AresApi extends Object {

    /** @var \Flame\Ares\Driver\IRequest */
    private $class;

    public function __construct(\Flame\Ares\Driver\IRequest $obj = NULL) {
        if ($obj === NULL) {
            $obj = new \Flame\Ares\Driver\Get();
        }

        $this->class = $obj;
    }

    public function loadData($inn) {
        $this->class->clean();
        return $this->class->loadData($inn);
    }

    public function getData() {
        return $this->class->loadData();
    }

}

class AresException extends \RuntimeException {

}
