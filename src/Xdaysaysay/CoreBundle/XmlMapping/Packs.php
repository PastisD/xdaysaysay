<?php

namespace Xdaysaysay\CoreBundle\XmlMapping;

use Sabre\Xml\Reader;
use Sabre\Xml\XmlDeserializable;

class Packs implements XmlDeserializable
{
    /**
     * @var Pack[]
     */
    public $packs = [];

    public static function xmlDeserialize(Reader $reader)
    {
        $packs = new self();

        $children = $reader->parseInnerTree();
        foreach ($children as $child) {
            if ($child['value'] instanceof Pack) {
                $packs->packs[] = $child['value'];
            }
        }

        return $packs;
    }

}