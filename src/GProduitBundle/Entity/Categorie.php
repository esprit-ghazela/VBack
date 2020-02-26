<?php

namespace GProduitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mgilet\NotificationBundle\NotifiableInterface;
use SBC\NotificationsBundle\Builder\NotificationBuilder;

use Symfony\Component\Validator\Constraints as Assert ;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity(repositoryClass="GProduitBundle\Repository\CategorieRepository")
 */
class Categorie
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string",unique=true)
     * @Assert\Length(min="3",minMessage="Attention !! Nom trop court")
     */
    private $nom;

    /**
     * @ORM\Column(type="string")
     * @Assert\Length(min="3",minMessage="Attention !! Description trop court")
     */
    private $description;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Categorie
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Categorie
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}

