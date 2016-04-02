<?php

namespace Xdaysaysay\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="irc_server")
 */
class IRCServer
{
    use TimestampableEntity;
    use BlameableEntity;

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
     * @ORM\OneToMany(targetEntity="Xdaysaysay\CoreBundle\Entity\Team", mappedBy="ircServer")
     */
    protected $teams;

    /**
     * @ORM\OneToMany(targetEntity="Xdaysaysay\CoreBundle\Entity\XdccName", mappedBy="ircServer")
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

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->teams = new ArrayCollection();
        $this->xdccnames = new ArrayCollection();
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
     * @param Team $teams
     * @return IRCServer
     */
    public function addTeam(Team $teams)
    {
        $this->teams[] = $teams;

        return $this;
    }

    /**
     * Remove teams
     *
     * @param Team $teams
     */
    public function removeTeam(Team $teams)
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
     * @param XdccName $xdccnames
     * @return IRCServer
     */
    public function addXdccname(XdccName $xdccnames)
    {
        $this->xdccnames[] = $xdccnames;

        return $this;
    }

    /**
     * Remove xdccnames
     *
     * @param XdccName $xdccnames
     */
    public function removeXdccname(XdccName $xdccnames)
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
