<?php

namespace Xdaysaysay\CoreBundle\XmlMapping;

use Sabre\Xml\Element\KeyValue;
use Sabre\Xml\Reader;
use Sabre\Xml\XmlDeserializable;

class Iroffer implements XmlDeserializable
{
    /**
     * @var Packs
     */
    public $packlist;

    /**
     * @var Sysinfo
     */
    public $sysinfo;

    public static function xmlDeserialize(Reader $reader)
    {
        $iroffer = new self();

        $keyValue = KeyValue::xmlDeserialize($reader);
        if (isset($keyValue['{}packlist'])) {
            $iroffer->packlist = $keyValue['{}packlist'];
        }
        if (isset($keyValue['{}sysinfo'])) {
            $iroffer->sysinfo = $keyValue['{}sysinfo'];
        }

        return $iroffer;
    }

}