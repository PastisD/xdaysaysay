<?php

namespace Xdaysaysay\CoreBundle\XmlMapping;

use Sabre\Xml\Element\KeyValue;
use Sabre\Xml\Reader;
use Sabre\Xml\XmlDeserializable;

class Stats implements XmlDeserializable
{
    public $version;
    public $uptime;
    public $totaluptime;
    public $lastupdate;

    static function xmlDeserialize(Reader $reader)
    {
        $idlequeue = new self();

        // Borrowing a parser from the KeyValue class.
        $keyValue = KeyValue::xmlDeserialize($reader);

        if (isset($keyValue['{}version'])) {
            $idlequeue->version = $keyValue['{}version'];
        }
        if (isset($keyValue['{}uptime'])) {
            $idlequeue->uptime = $keyValue['{}uptime'];
        }
        if (isset($keyValue['{}totaluptime'])) {
            $idlequeue->totaluptime = $keyValue['{}totaluptime'];
        }
        if (isset($keyValue['{}lastupdate'])) {
            $idlequeue->lastupdate = $keyValue['{}lastupdate'];
        }

        return $idlequeue;
    }

}