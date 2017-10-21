<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
//use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * Admin
 *
 * @ORM\Table(name="admin")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AdminRepository")
 */
class Admin extends BaseUser {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct() {
        parent::__construct();
        // your own logic
        $this->addRole("ROLE_ADMIN");
    }

//    public function setEmail($email) {
//        parent::setEmail($email);
//        $this->setUsername($email);
//    }
}
