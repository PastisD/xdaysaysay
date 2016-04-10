<?php

namespace Xdaysaysay\CoreBundle\XmlMapping;

use Sabre\Xml\Element\KeyValue;
use Sabre\Xml\Reader;
use Sabre\Xml\XmlDeserializable;

class Idlequeue implements XmlDeserializable
{
    public $queueuse;
    public $queuemax;

    static public function xmlDeserialize(Reader $reader)
    {
        $idlequeue = new self();

        // Borrowing a parser from the KeyValue class.
        $keyValue = KeyValue::xmlDeserialize($reader);

        if (isset($keyValue['{}queueuse'])) {
            $idlequeue->queueuse = $keyValue['{}queueuse'];
        }
        if (isset($keyValue['{}queuemax'])) {
            $idlequeue->queuemax = $keyValue['{}queuemax'];
        }

        return $idlequeue;
    }

}