<?php

namespace Tissou\XdaysaysayBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="team")
 */
class Team {
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", options={"unsigned"=true})
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="IRCServer", inversedBy="teams")
     * @ORM\JoinColumn(name="id_ircserver", referencedColumnName="id", nullable=false)
     **/
	protected $ircServer;

	/**
	 * @ORM\ManyToMany(targetEntity="Xdcc")
	 * @ORM\JoinTable(name="team_xdcc",
	 *      joinColumns={@ORM\JoinColumn(name="id_team", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="id_xdcc", referencedColumnName="id")}
	 *      )
	 **/
    /**
     * @ORM\ManyToMany(targetEntity="Xdcc", cascade={"persist"})
     */
	protected $xdccs;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	protected $name;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	protected $chan_name;

	/**
	 * @ORM\Column(type="string", nullable=true, length=255)
	 */
	protected $website;

	/**
	 * @ORM\Column(type="boolean")
	 */
	protected $visible = true;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->xdccs = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Team
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
     * Set chan_name
     *
     * @param string $chanName
     * @return Team
     */
    public function setChanName($chanName)
    {
        $this->chan_name = $chanName;

        return $this;
    }

    /**
     * Get chan_name
     *
     * @return string 
     */
    public function getChanName()
    {
        return $this->chan_name;
    }

    /**
     * Set website
     *
     * @param string $website
     * @return Team
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string 
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set visible
     *
     * @param boolean $visible
     * @return Team
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
     * Set ircServer
     *
     * @param \Tissou\XdaysaysayBundle\Entity\IRCServer $ircServer
     * @return Team
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

    /**
     * Add xdccs
     *
     * @param \Tissou\XdaysaysayBundle\Entity\Xdcc $xdccs
     * @return Team
     */
    public function addXdcc(\Tissou\XdaysaysayBundle\Entity\Xdcc $xdccs)
    {
        $this->xdccs[] = $xdccs;

        return $this;
    }

    /**
     * Remove xdccs
     *
     * @param \Tissou\XdaysaysayBundle\Entity\Xdcc $xdccs
     */
    public function removeXdcc(\Tissou\XdaysaysayBundle\Entity\Xdcc $xdccs)
    {
        $this->xdccs->removeElement($xdccs);
    }

    /**
     * Get xdccs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getXdccs()
    {
        return $this->xdccs;
    }
}
