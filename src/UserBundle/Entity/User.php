<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 * @UniqueEntity(fields="username", message="Cet Email est déjà utilisé")
 */
class User implements AdvancedUserInterface, \Serializable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $username;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $roles;

    public static $rolesList = [
        'Super Admin' => 'ROLE_SUPER_ADMIN',
        'Administrateur' => 'ROLE_ADMIN',
        'Utilisateur' => 'ROLE_USER',
    ];

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    public function __construct()
    {
        $this->isActive = true;
    }

    public function getId()
    {
       return $this->id;
    }

    public function getUsername()
    {
       return $this->username;
    }

    public function setUsername($username)
    {
       $this->username = $username;
    }

    public function getPlainPassword()
    {
       return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
       $this->plainPassword = $password;
    }

    public function getPassword()
    {
       return $this->password;
    }

    public function setPassword($password)
    {
       $this->password = $password;
    }

    public function getSalt()
    {
       return null;
    }

    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    public function getRoles()
    {
        return [$this->roles];
    }

    public function getRoleUF()
    {
        foreach(self::$rolesList as $key => $role){
            if($role == $this->roles)
                return $key;
        }

        return;
    }

    public function eraseCredentials()
    {
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->password,
            $this->roles,
            $this->isActive,
        ]);
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->roles,
            $this->isActive,
        ) = unserialize($serialized);
    }
}
