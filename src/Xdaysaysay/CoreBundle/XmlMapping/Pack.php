<?php

namespace Xdaysaysay\CoreBundle\XmlMapping;

use Sabre\Xml\Element\KeyValue;
use Sabre\Xml\Reader;
use Sabre\Xml\XmlDeserializable;

class Pack implements XmlDeserializable
{
    public $packnr;
    public $packname;
    public $packsize;
    public $packbytes;
    public $packgets;
    public $adddate;
    public $md5sum;
    public $crc32;

    static public function xmlDeserialize(Reader $reader)
    {
        $pack = new self();

        // Borrowing a parser from the KeyValue class.
        $keyValue = KeyValue::xmlDeserialize($reader);

        if (isset($keyValue['{}packnr'])) {
            $pack->packnr = $keyValue['{}packnr'];
        }
        if (isset($keyValue['{}packname'])) {
            $pack->packname = $keyValue['{}packname'];
        }
        if (isset($keyValue['{}packsize'])) {
            $pack->packsize = $keyValue['{}packsize'];
        }
        if (isset($keyValue['{}packbytes'])) {
            $pack->packbytes = $keyValue['{}packbytes'];
        }
        if (isset($keyValue['{}packgets'])) {
            $pack->packgets = $keyValue['{}packgets'];
        }
        if (isset($keyValue['{}adddate'])) {
            $pack->adddate = $keyValue['{}adddate'];
        }
        if (isset($keyValue['{}md5sum'])) {
            $pack->md5sum = $keyValue['{}md5sum'];
        }
        if (isset($keyValue['{}crc32'])) {
            $pack->crc32 = $keyValue['{}crc32'];
        }

        return $pack;
    }

}