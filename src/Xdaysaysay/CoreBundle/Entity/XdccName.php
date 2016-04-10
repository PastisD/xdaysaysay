<?php

namespace Xdaysaysay\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity;
 * @ORM\Table(name="xdcc_name")
 */
class XdccName
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Xdaysaysay\CoreBundle\Entity\Xdcc", inversedBy="xdccnames")
     * @ORM\JoinColumn(name="id_xdcc", referencedColumnName="id")
     */
    protected $xdcc;


    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Xdaysaysay\CoreBundle\Entity\IRCServer", inversedBy="xdccnames")
     * @ORM\JoinColumn(name="id_ircserver", referencedColumnName="id")
     */
    protected $ircServer;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Set name
     *
     * @param string $name
     * @return XdccName
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set xdcc
     *
     * @param Xdcc $xdcc
     * @return XdccName
     */
    public function setXdcc(Xdcc $xdcc)
    {
        $this->xdcc = $xdcc;

        return $this;
    }

    /**
     * Get xdcc
     *
     * @return Xdcc
     */
    public function getXdcc()
    {
        return $this->xdcc;
    }

    /**
     * Set ircServer
     *
     * @param IRCServer $ircServer
     * @return XdccName
     */
    public function setIrcServer(IRCServer $ircServer)
    {
        $this->ircServer = $ircServer;

        return $this;
    }

    /**
     * Get ircServer
     *
     * @return IRCServer
     */
    public function getIrcServer()
    {
        return $this->ircServer;
    }
}
