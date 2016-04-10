<?php

namespace Xdaysaysay\CoreBundle\XmlMapping;

use Sabre\Xml\Element\KeyValue;
use Sabre\Xml\Reader;
use Sabre\Xml\XmlDeserializable;

class Network implements XmlDeserializable
{
    public $networkname;
    public $confignick;
    public $currentnick;
    public $servername;
    public $currentservername;
    public $channel;

    static public function xmlDeserialize(Reader $reader)
    {
        $network = new self();

        // Borrowing a parser from the KeyValue class.
        $keyValue = KeyValue::xmlDeserialize($reader);

        if (isset($keyValue['{}networkname'])) {
            $network->networkname = $keyValue['{}networkname'];
        }
        if (isset($keyValue['{}confignick'])) {
            $network->confignick = $keyValue['{}confignick'];
        }
        if (isset($keyValue['{}currentnick'])) {
            $network->currentnick = $keyValue['{}currentnick'];
        }
        if (isset($keyValue['{}servername'])) {
            $network->servername = $keyValue['{}servername'];
        }
        if (isset($keyValue['{}currentservername'])) {
            $network->currentservername = $keyValue['{}currentservername'];
        }
        if (isset($keyValue['{}channel'])) {
            $network->channel = $keyValue['{}channel'];
        }

        return $network;
    }

}