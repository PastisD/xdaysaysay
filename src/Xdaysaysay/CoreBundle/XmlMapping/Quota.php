<?php

namespace Xdaysaysay\CoreBundle\XmlMapping;

use Sabre\Xml\Element\KeyValue;
use Sabre\Xml\Reader;
use Sabre\Xml\XmlDeserializable;

class Quota implements XmlDeserializable
{
    public $packsum;
    public $diskspace;
    public $transfereddaily;
    public $transferedweekly;
    public $transferedmonthly;
    public $transferedtotal;
    public $transferedtotalbytes;

    public static function xmlDeserialize(Reader $reader)
    {
        $idlequeue = new self();

        // Borrowing a parser from the KeyValue class.
        $keyValue = KeyValue::xmlDeserialize($reader);

        if (isset($keyValue['{}packsum'])) {
            $idlequeue->packsum = $keyValue['{}packsum'];
        }
        if (isset($keyValue['{}diskspace'])) {
            $idlequeue->diskspace = $keyValue['{}diskspace'];
        }
        if (isset($keyValue['{}transfereddaily'])) {
            $idlequeue->transfereddaily = $keyValue['{}transfereddaily'];
        }
        if (isset($keyValue['{}transferedweekly'])) {
            $idlequeue->transferedweekly = $keyValue['{}transferedweekly'];
        }
        if (isset($keyValue['{}transferedmonthly'])) {
            $idlequeue->transferedmonthly = $keyValue['{}transferedmonthly'];
        }
        if (isset($keyValue['{}transferedtotal'])) {
            $idlequeue->transferedtotal = $keyValue['{}transferedtotal'];
        }
        if (isset($keyValue['{}transferedtotalbytes'])) {
            $idlequeue->transferedtotalbytes = $keyValue['{}transferedtotalbytes'];
        }

        return $idlequeue;
    }

}