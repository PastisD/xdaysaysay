<?php

namespace Xdaysaysay\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="team")
 */
class Team
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
     * @ORM\ManyToOne(targetEntity="Xdaysaysay\CoreBundle\Entity\IRCServer", inversedBy="teams")
     * @ORM\JoinColumn(name="id_ircserver", referencedColumnName="id", nullable=false)
     **/
    protected $ircServer;

    /**
     * @ORM\ManyToMany(targetEntity="Xdaysaysay\CoreBundle\Entity\Xdcc", mappedBy="teams", cascade={"persist"})
     **/
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

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->xdccs = new ArrayCollection();
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
     * @param IRCServer $ircServer
     * @return Team
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

    /**
     * Add xdccs
     *
     * @param Xdcc $xdccs
     * @return Team
     */
    public function addXdcc(Xdcc $xdccs)
    {
        $this->xdccs[] = $xdccs;

        return $this;
    }

    /**
     * Remove xdccs
     *
     * @param Xdcc $xdccs
     */
    public function removeXdcc(Xdcc $xdccs)
    {
        $this->xdccs->removeElement($xdccs);
    }

    /**
     * Get xdccs
     *
     * @return Xdcc[]
     */
    public function getXdccs()
    {
        return $this->xdccs;
    }
}
