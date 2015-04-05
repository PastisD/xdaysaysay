<?php
/**
 * Created by PhpStorm.
 * User: Ewan
 * Date: 14/03/2015
 * Time: 20:37
 */

namespace Tissou\XdaysaysayBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Tissou\XdaysaysayBundle\Entity\XdccNameRepository");
 * @ORM\Table(name="xdcc_name")
 */
class XdccName {
	/**
	 * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="Xdcc", inversedBy="packs")
	 * @ORM\JoinColumn(name="id_xdcc", referencedColumnName="id", nullable=false)
	 */
	protected $xdcc;


    /**
     * @ORM\ManyToOne(targetEntity="IRCServer", inversedBy="xdccnames")
     * @ORM\JoinColumn(name="id_ircserver", referencedColumnName="id", nullable=false)
     */
    protected $ircServer;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	protected $name;

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
     * @param \Tissou\XdaysaysayBundle\Entity\Xdcc $xdcc
     * @return XdccName
     */
    public function setXdcc(\Tissou\XdaysaysayBundle\Entity\Xdcc $xdcc)
    {
        $this->xdcc = $xdcc;

        return $this;
    }

    /**
     * Get xdcc
     *
     * @return \Tissou\XdaysaysayBundle\Entity\Xdcc 
     */
    public function getXdcc()
    {
        return $this->xdcc;
    }

    /**
     * Set ircServer
     *
     * @param \Tissou\XdaysaysayBundle\Entity\IRCServer $ircServer
     * @return XdccName
     */
    public function setIrcServer(\Tissou\XdaysaysayBundle\Entity\IRCServer $ircServer)
    {
        $this->ircServer = $ircServer;

        return $this;
    }

    /**
     * Get ircServer
     *
     * @return \Tissou\XdaysaysayBundle\Entity\IRCServer 
     */
    public function getIrcServer()
    {
        return $this->ircServer;
    }
}
