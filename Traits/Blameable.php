<?php

namespace Bacon\Bundle\CoreBundle\Traits;

use Doctrine\ORM\Mapping as ORM;
use Bacon\Bundle\UserBundle\Entity\User;
use Gedmo\Mapping\Annotation as Gedmo;

trait Blameable
{
    /**
     * @var User
     *
     * @Gedmo\Blameable(on="create")
     *
     * @ORM\ManyToOne(targetEntity="Bacon\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     */
    protected $createdBy;

    /**
     * @var Users
     * @Gedmo\Blameable(on="update")
     * @ORM\ManyToOne(targetEntity="Bacon\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="updated_by", referencedColumnName="id")
     */
    protected $updatedBy;

    /**
     * @return User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param User $createdBy
     * @return Blameable
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * @return Users
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * @param Users $updatedBy
     * @return Blameable
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;
        return $this;
    }
}