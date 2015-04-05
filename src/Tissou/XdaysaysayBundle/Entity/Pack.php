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
 * @ORM\Entity
 * @ORM\Table(name="pack")
 */
class Pack {
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", options={"unsigned"=true})
	 */
	protected $id;

	/**
	 * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="Xdcc", inversedBy="packs")
	 * @ORM\JoinColumn(name="id_xdcc", referencedColumnName="id")
	 */
	protected $xdcc;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	protected $name;

	/**
	 * @ORM\Column(type="integer", nullable=true, options={"unsigned"=true})
	 */
	protected $size;

	/**
	 * @ORM\Column(type="integer", nullable=true, options={"unsigned"=true})
	 */
	protected $gets;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $adddate;

	/**
	 * @ORM\Column(type="string", nullable=true, length=32)
	 */
	protected $md5sum;

	/**
	 * @ORM\Column(type="string", nullable=true, length=8)
	 */
	protected $crc32;

    /**
     * Set id
     *
     * @param integer $id
     * @return Pack
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * @return Pack
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
     * Set size
     *
     * @param integer $size
     * @return Pack
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer 
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set gets
     *
     * @param integer $gets
     * @return Pack
     */
    public function setGets($gets)
    {
        $this->gets = $gets;

        return $this;
    }

    /**
     * Get gets
     *
     * @return integer 
     */
    public function getGets()
    {
        return $this->gets;
    }

    /**
     * Set adddate
     *
     * @param \DateTime $adddate
     * @return Pack
     */
    public function setAdddate($adddate)
    {
        $this->adddate = $adddate;

        return $this;
    }

    /**
     * Get adddate
     *
     * @return \DateTime 
     */
    public function getAdddate()
    {
        return $this->adddate;
    }

    /**
     * Set md5sum
     *
     * @param string $md5sum
     * @return Pack
     */
    public function setMd5sum($md5sum)
    {
        $this->md5sum = $md5sum;

        return $this;
    }

    /**
     * Get md5sum
     *
     * @return string 
     */
    public function getMd5sum()
    {
        return $this->md5sum;
    }

    /**
     * Set crc32
     *
     * @param string $crc32
     * @return Pack
     */
    public function setCrc32($crc32)
    {
        $this->crc32 = $crc32;

        return $this;
    }

    /**
     * Get crc32
     *
     * @return string 
     */
    public function getCrc32()
    {
        return $this->crc32;
    }

    /**
     * Set xdcc
     *
     * @param \Tissou\XdaysaysayBundle\Entity\Xdcc $xdcc
     * @return Pack
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
}
