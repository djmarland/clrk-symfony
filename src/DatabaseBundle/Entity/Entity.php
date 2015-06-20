<?php
namespace DatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

abstract class Entity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $created_at;

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $updated_at;

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set createdAt
     *
     * @ORM\PrePersist
     */
    public function setCreatedAt()
    {
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
    }

    /**
     * Set updatedAt
     *
     * @ORM\PreUpdate
     */
    public function setUpdatedAt()
    {
        $this->updated_at = new \DateTime();
    }
}
