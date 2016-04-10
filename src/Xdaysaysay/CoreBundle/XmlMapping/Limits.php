<?php

namespace Xdaysaysay\CoreBundle\XmlMapping;

use Sabre\Xml\Element\KeyValue;
use Sabre\Xml\Reader;
use Sabre\Xml\XmlDeserializable;

class Limits implements XmlDeserializable
{
    public $minspeed;
    public $maxspeed;

    public static function xmlDeserialize(Reader $reader)
    {
        $idlequeue = new self();

        // Borrowing a parser from the KeyValue class.
        $keyValue = KeyValue::xmlDeserialize($reader);

        if (isset($keyValue['{}minspeed'])) {
            $idlequeue->minspeed = $keyValue['{}minspeed'];
        }
        if (isset($keyValue['{}maxspeed'])) {
            $idlequeue->maxspeed = $keyValue['{}maxspeed'];
        }

        return $idlequeue;
    }

}