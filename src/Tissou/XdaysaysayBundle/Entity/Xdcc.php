<?php

namespace Tissou\XdaysaysayBundle\Entity;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity;
 * @ORM\Table(name="xdcc")
 */
class Xdcc {
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", options={"unsigned"=true})
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\ManyToOne(targetEntity="Server", inversedBy="xdccs")
	 * @ORM\JoinColumn(name="id_server", referencedColumnName="id")
	 */
	protected $server;

	/**
	 * @ORM\OneToMany(targetEntity="Pack", mappedBy="xdcc")
	 */
	protected $packs;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	protected $url;

	/**
	 * @ORM\Column(type="string", nullable=true, options={"unsigned"=true})
	 */
	protected $diskspace;

	/**
	 * @ORM\Column(type="string", nullable=true, options={"unsigned"=true})
	 */
	protected $transferedtotal;

	/**
	 * @ORM\Column(type="integer", nullable=true, options={"unsigned"=true})
	 */
	protected $totaluptime;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $lastupdate;

	/**
	 * @ORM\Column(type="boolean")
	 */
	protected $visible = true;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->teams = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Xdcc
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set packsum
     *
     * @param integer $packsum
     * @return Xdcc
     */
    public function setPacksum($packsum)
    {
        $this->packsum = $packsum;

        return $this;
    }

    /**
     * Get packsum
     *
     * @return integer 
     */
    public function getPacksum()
    {
        return $this->packsum;
    }

    /**
     * Set diskspace
     *
     * @param integer $diskspace
     * @return Xdcc
     */
    public function setDiskspace($diskspace)
    {
        $this->diskspace = $diskspace;

        return $this;
    }

    /**
     * Get diskspace
     *
     * @return integer 
     */
    public function getDiskspace()
    {
        return $this->diskspace;
    }

    /**
     * Set transferedtotal
     *
     * @param integer $transferedtotal
     * @return Xdcc
     */
    public function setTransferedtotal($transferedtotal)
    {
        $this->transferedtotal = $transferedtotal;

        return $this;
    }

    /**
     * Get transferedtotal
     *
     * @return integer 
     */
    public function getTransferedtotal()
    {
        return $this->transferedtotal;
    }

    /**
     * Set totaluptime
     *
     * @param integer $totaluptime
     * @return Xdcc
     */
    public function setTotaluptime($totaluptime)
    {
        $this->totaluptime = $totaluptime;

        return $this;
    }

    /**
     * Get totaluptime
     *
     * @return integer 
     */
    public function getTotaluptime()
    {
        return $this->totaluptime;
    }

    /**
     * Set lastupdate
     *
     * @param \DateTime $lastupdate
     * @return Xdcc
     */
    public function setLastupdate($lastupdate)
    {
        $this->lastupdate = $lastupdate;

        return $this;
    }

    /**
     * Get lastupdate
     *
     * @return \DateTime 
     */
    public function getLastupdate()
    {
        return $this->lastupdate;
    }

    /**
     * Set visible
     *
     * @param boolean $visible
     * @return Xdcc
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get visible
     *
     * @return boolean 
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * Set server
     *
     * @param \Tissou\XdaysaysayBundle\Entity\Server $server
     * @return Xdcc
     */
    public function setServer(\Tissou\XdaysaysayBundle\Entity\Server $server = null)
    {
        $this->server = $server;

        return $this;
    }

    /**
     * Get server
     *
     * @return \Tissou\XdaysaysayBundle\Entity\Server 
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * Add packs
     *
     * @param \Tissou\XdaysaysayBundle\Entity\Pack $packs
     * @return Xdcc
     */
    public function addPack(\Tissou\XdaysaysayBundle\Entity\Pack $packs)
    {
        $this->packs[] = $packs;

        return $this;
    }

    /**
     * Remove packs
     *
     * @param \Tissou\XdaysaysayBundle\Entity\Pack $packs
     */
    public function removePack(\Tissou\XdaysaysayBundle\Entity\Pack $packs)
    {
        $this->packs->removeElement($packs);
    }

    /**
     * Get packs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPacks()
    {
        return $this->packs;
    }
}
