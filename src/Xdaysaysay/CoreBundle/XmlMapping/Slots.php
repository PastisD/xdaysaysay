<?php

namespace Xdaysaysay\CoreBundle\XmlMapping;

use Sabre\Xml\Element\KeyValue;
use Sabre\Xml\Reader;
use Sabre\Xml\XmlDeserializable;

class Slots implements XmlDeserializable
{
    public $slotsfree;
    public $slotsmax;

    public static function xmlDeserialize(Reader $reader)
    {
        $slot = new self();

        // Borrowing a parser from the KeyValue class.
        $keyValue = KeyValue::xmlDeserialize($reader);

        if (isset($keyValue['{}slotsfree'])) {
            $slot->slotsfree = $keyValue['{}slotsfree'];
        }
        if (isset($keyValue['{}slotsmax'])) {
            $slot->slotsmax = $keyValue['{}slotsmax'];
        }

        return $slot;
    }

}