<?php

namespace Xdaysaysay\CoreBundle\XmlMapping;

use Sabre\Xml\Element\KeyValue;
use Sabre\Xml\Reader;
use Sabre\Xml\XmlDeserializable;

class Bandwidth implements XmlDeserializable
{
    public $banduse;
    public $bandmax;

    static public function xmlDeserialize(Reader $reader)
    {
        $idlequeue = new self();

        // Borrowing a parser from the KeyValue class.
        $keyValue = KeyValue::xmlDeserialize($reader);

        if (isset($keyValue['{}banduse'])) {
            $idlequeue->banduse = $keyValue['{}banduse'];
        }
        if (isset($keyValue['{}bandmax'])) {
            $idlequeue->bandmax = $keyValue['{}bandmax'];
        }

        return $idlequeue;
    }

}