<?php

namespace Xdaysaysay\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="Xdaysaysay\CoreBundle\Entity\Repository\XdccRepository");
 * @ORM\Table(name="xdcc")
 */
class Xdcc
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
     * @ORM\ManyToOne(targetEntity="Xdaysaysay\CoreBundle\Entity\Server", inversedBy="xdccs")
     * @ORM\JoinColumn(name="id_server", referencedColumnName="id", nullable=false)
     */
    protected $server;

    /**
     * @ORM\OneToMany(targetEntity="Xdaysaysay\CoreBundle\Entity\Pack", mappedBy="xdcc", cascade={"all"}, orphanRemoval=true)
     * @ORM\JoinColumn(name="id_xdcc", referencedColumnName="id")
     */
    protected $packs;

    /**
     * @ORM\ManyToMany(targetEntity="Xdaysaysay\CoreBundle\Entity\Team", inversedBy="xdccs")
     * @ORM\JoinTable(name="team_xdcc",
     *      joinColumns={@ORM\JoinColumn(name="id_xdcc", referencedColumnName="id", nullable=false)},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_team", referencedColumnName="id", nullable=false)}
     *      )
     **/
    protected $teams;

    /**
     * @ORM\OneToMany(targetEntity="Xdaysaysay\CoreBundle\Entity\XdccName", mappedBy="xdcc", cascade={"all"}, orphanRemoval=true)
     */
    protected $xdccnames;

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
        $this->teams = new ArrayCollection();
        $this->xdccnames = new ArrayCollection();
        $this->packs = new ArrayCollection();
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
     * @param Server $server
     * @return Xdcc
     */
    public function setServer(Server $server = null)
    {
        $this->server = $server;

        return $this;
    }

    /**
     * Get server
     *
     * @return Server
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * Add packs
     *
     * @param Pack $packs
     * @return Xdcc
     */
    public function addPack(Pack $packs)
    {
        $this->packs[] = $packs;

        return $this;
    }

    /**
     * Remove packs
     *
     * @param Pack $packs
     */
    public function removePack(Pack $packs)
    {
        $this->packs->removeElement($packs);
    }

    /**
     * Get packs
     *
     * @return ArrayCollection|Pack[]
     */
    public function getPacks()
    {
        return $this->packs;
    }

    /**
     * Add team
     *
     * @param Team $team
     *
     * @return Xdcc
     */
    public function addTeam(Team $team)
    {
        $this->teams[] = $team;

        return $this;
    }

    /**
     * Remove team
     *
     * @param Team $team
     */
    public function removeTeam(Team $team)
    {
        $this->teams->removeElement($team);
    }

    /**
     * Get teams
     *
     * @return ArrayCollection|Team[]
     */
    public function getTeams()
    {
        return $this->teams;
    }

    /**
     * Add xdccname
     *
     * @param XdccName $xdccname
     *
     * @return Xdcc
     */
    public function addXdccname(XdccName $xdccname)
    {
        $this->xdccnames[] = $xdccname;

        return $this;
    }

    /**
     * Remove xdccname
     *
     * @param XdccName $xdccname
     */
    public function removeXdccname(XdccName $xdccname)
    {
        $this->xdccnames->removeElement($xdccname);
    }

    /**
     * Get xdccnames
     *
     * @return XdccName[]
     */
    public function getXdccnames()
    {
        return $this->xdccnames;
    }
}
