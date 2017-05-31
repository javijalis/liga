<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 */
abstract class LaLigaEntity
{
    const DATE_FORMAT = 'Y-m-d H:i:s';

    /**
     * @var integer $id
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @var  string
     *
     * @ORM\Column(name="created_at",type="string", length=255)
     */
    private $createdAt;

    /**
     * @var  string
     *
     * @ORM\Column(name="updated_at",type="string", length=255)
     */
    private $updatedAt;


    /**
     * Constructor
     */
    public function __construct()
    {

    }

    /**
     * @ORM\PrePersist()
     */
    public function persistDateValues()
    {
        $this->updatedAt = date(self::DATE_FORMAT);
        $this->createdAt = date(self::DATE_FORMAT);
    }

    /**
     * @ORM\PreUpdate()
     */
    public function updateDateValues()
    {
        $this->updatedAt = date(self::DATE_FORMAT);
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
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }


    /**
     * Set createdAt
     *
     * @param string $createdAt
     * @return OzoneEntity
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param string $updatedAt
     * @return OzoneEntity
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }


}
