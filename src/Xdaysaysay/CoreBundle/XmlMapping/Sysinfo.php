<?php

namespace Xdaysaysay\CoreBundle\XmlMapping;

use Sabre\Xml\Element\KeyValue;
use Sabre\Xml\Reader;
use Sabre\Xml\XmlDeserializable;

class Sysinfo implements XmlDeserializable
{
    /**
     * @var Slots
     */
    public $slots;

    /**
     * @var Mainqueue
     */
    public $mainqueue;

    /**
     * @var Idlequeue
     */
    public $idlequeue;

    /**
     * @var Bandwidth
     */
    public $bandwidth;

    /**
     * @var Quota
     */
    public $quota;

    /**
     * @var Limits
     */
    public $limits;

    /**
     * @var Network[]
     */
    public $networks;

    /**
     * @var Stats
     */
    public $stats;

    public static function xmlDeserialize(Reader $reader)
    {
        $sysinfo = new self();

        // Borrowing a parser from the KeyValue class.
        $children = $reader->parseInnerTree();

        foreach ($children as $child) {
            if ($child['name'] === '{}slots') {
                $sysinfo->slots = $child['value'];
            }
            if ($child['name'] === '{}mainqueue') {
                $sysinfo->mainqueue = $child['value'];
            }
            if ($child['name'] === '{}idlequeue') {
                $sysinfo->idlequeue = $child['value'];
            }
            if ($child['name'] === '{}bandwidth') {
                $sysinfo->bandwidth = $child['value'];
            }
            if ($child['name'] === '{}quota') {
                $sysinfo->quota = $child['value'];
            }
            if ($child['name'] === '{}limits') {
                $sysinfo->limits = $child['value'];
            }
            if ($child['name'] === '{}network') {
                $sysinfo->networks[] = $child['value'];
            }
            if ($child['name'] === '{}stats') {
                $sysinfo->stats = $child['value'];
            }
        }


        return $sysinfo;
    }

}