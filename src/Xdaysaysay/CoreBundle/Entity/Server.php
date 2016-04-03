<?php

namespace Xdaysaysay\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="server")
 */
class Server
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
     * @ORM\OneToMany(targetEntity="Xdaysaysay\CoreBundle\Entity\Xdcc", mappedBy="server")
     */
    protected $xdccs;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $host;

    /**
     * @ORM\Column(type="integer")
     */
    protected $http_port;

    /**
     * @ORM\Column(name="`ssl`", type="boolean")
     */
    protected $ssl = false;

    public function __toString()
    {
        return $this->getName() . '(' . $this->getHost() . ')';
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
     * @return Server
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
     * @return Server
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
     * Set http_port
     *
     * @param integer $httpPort
     * @return Server
     */
    public function setHttpPort($httpPort)
    {
        $this->http_port = $httpPort;

        return $this;
    }

    /**
     * Get http_port
     *
     * @return integer
     */
    public function getHttpPort()
    {
        return $this->http_port;
    }

    /**
     * Set ssl
     *
     * @param boolean $ssl
     * @return Server
     */
    public function setSsl($ssl)
    {
        $this->ssl = $ssl;

        return $this;
    }

    /**
     * Get ssl
     *
     * @return boolean
     */
    public function getSsl()
    {
        return $this->ssl;
    }

    /**
     * Add xdccs
     *
     * @param Xdcc $xdccs
     * @return Server
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
