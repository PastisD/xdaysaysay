<?php
namespace Tissou\XdaysaysayBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="server")
 */
class Server {
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", options={"unsigned"=true})
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\OneToMany(targetEntity="xdcc", mappedBy="server")
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
     * @param \Tissou\XdaysaysayBundle\Entity\xdcc $xdccs
     * @return Server
     */
    public function addXdcc(\Tissou\XdaysaysayBundle\Entity\xdcc $xdccs)
    {
        $this->xdccs[] = $xdccs;

        return $this;
    }

    /**
     * Remove xdccs
     *
     * @param \Tissou\XdaysaysayBundle\Entity\xdcc $xdccs
     */
    public function removeXdcc(\Tissou\XdaysaysayBundle\Entity\xdcc $xdccs)
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
