<?php

namespace Xdaysaysay\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class XdaysaysayUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
