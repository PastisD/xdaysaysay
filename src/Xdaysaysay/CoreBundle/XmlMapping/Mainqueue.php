<?php

namespace Xdaysaysay\CoreBundle\XmlMapping;

use Sabre\Xml\Element\KeyValue;
use Sabre\Xml\Reader;
use Sabre\Xml\XmlDeserializable;

class Mainqueue implements XmlDeserializable
{
    public $queueuse;
    public $queuemax;

    static public function xmlDeserialize(Reader $reader)
    {
        $mainqueue = new self();

        // Borrowing a parser from the KeyValue class.
        $keyValue = KeyValue::xmlDeserialize($reader);

        if (isset($keyValue['{}queueuse'])) {
            $mainqueue->queueuse = $keyValue['{}queueuse'];
        }
        if (isset($keyValue['{}queuemax'])) {
            $mainqueue->queuemax = $keyValue['{}queuemax'];
        }

        return $mainqueue;
    }

}