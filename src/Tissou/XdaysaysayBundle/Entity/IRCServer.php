<?php
/**
 * Created by PhpStorm.
 * User: Ewan
 * Date: 14/03/2015
 * Time: 20:28
 */

namespace Tissou\XdaysaysayBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="irc_server")
 */
class IRCServer {
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", options={"unsigned"=true})
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	protected $name;
    
    /**
     * @ORM\OneToMany(targetEntity="Team", mappedBy="ircServer")
     */
    protected $teams;
    
    /**
     * @ORM\OneToMany(targetEntity="XdccName", mappedBy="ircServer")
     */
    protected $xdccnames;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	protected $host;

	/**
	 * @ORM\Column(type="integer", options={"unsigned"=true})
	 */
	protected $port;
	/**
	 * @ORM\Column(type="integer", nullable=true, options={"unsigned"=true})
	 */
	protected $port_ssl;
	/**
	 * @ORM\Column(type="string", nullable=true, length=255)
	 */
	protected $website;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->teams = new \Doctrine\Common\Collections\ArrayCollection();
        $this->xdccnames = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return IRCServer
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
     * Set host
     *
     * @param string $host
     * @return IRCServer
     */
    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * Get host
     *
     * @return string 
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Set port
     *
     * @param integer $port
     * @return IRCServer
     */
    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * Get port
     *
     * @return integer 
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Set port_ssl
     *
     * @param integer $portSsl
     * @return IRCServer
     */
    public function setPortSsl($portSsl)
    {
        $this->port_ssl = $portSsl;

        return $this;
    }

    /**
     * Get port_ssl
     *
     * @return integer 
     */
    public function getPortSsl()
    {
        return $this->port_ssl;
    }

    /**
     * Set website
     *
     * @param string $website
     * @return IRCServer
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
     * Add teams
     *
     * @param \Tissou\XdaysaysayBundle\Entity\Team $teams
     * @return IRCServer
     */
    public function addTeam(\Tissou\XdaysaysayBundle\Entity\Team $teams)
    {
        $this->teams[] = $teams;

        return $this;
    }

    /**
     * Remove teams
     *
     * @param \Tissou\XdaysaysayBundle\Entity\Team $teams
     */
    public function removeTeam(\Tissou\XdaysaysayBundle\Entity\Team $teams)
    {
        $this->teams->removeElement($teams);
    }

    /**
     * Get teams
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTeams()
    {
        return $this->teams;
    }

    /**
     * Add xdccnames
     *
     * @param \Tissou\XdaysaysayBundle\Entity\XdccName $xdccnames
     * @return IRCServer
     */
    public function addXdccname(\Tissou\XdaysaysayBundle\Entity\XdccName $xdccnames)
    {
        $this->xdccnames[] = $xdccnames;

        return $this;
    }

    /**
     * Remove xdccnames
     *
     * @param \Tissou\XdaysaysayBundle\Entity\XdccName $xdccnames
     */
    public function removeXdccname(\Tissou\XdaysaysayBundle\Entity\XdccName $xdccnames)
    {
        $this->xdccnames->removeElement($xdccnames);
    }

    /**
     * Get xdccnames
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getXdccnames()
    {
        return $this->xdccnames;
    }
}
