<?php

namespace GProduitBundle\Entity;
use Mgilet\NotificationBundle\NotifiableInterface;
use SBC\NotificationsBundle\Builder\NotificationBuilder;
use Symfony\Component\Validator\Constraints as Assert ;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity(repositoryClass="GProduitBundle\Repository\ProduitRepository")
 */
class Produit implements NotifiableInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Attention !! Le nom ne peut pas étre vide")
     * @Assert\Length(min="3",minMessage="Attention !! Nom trop court")
     */
    private $nom;

    /**
     * @ORM\Column(type="string")
     * @Assert\Length(min="5",minMessage="Attention !! Description trop courte")
     */
    private $description;
    /**
     * @ORM\Column(type="string")
     */
    private $marque ;

    /**
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumn(name="id_categorie",referencedColumnName="id")
     */
    private $categorie;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="partenaire",referencedColumnName="id")
     */
    private $partenaire;

    /**
     * @return mixed
     */
    public function getMarque()
    {
        return $this->marque;
    }

    /**
     * @return mixed
     */
    public function getPartenaire()
    {
        return $this->partenaire;
    }

    /**
     * @param mixed $partenaire
     */
    public function setPartenaire($partenaire)
    {
        $this->partenaire = $partenaire;
    }

    /**
     * @param mixed $marque
     */
    public function setMarque($marque)
    {
        $this->marque = $marque;
    }



    /**
     * @return mixed
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param mixed $categorie
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
    }



    /**
     * @ORM\Column(type="float")
     * @Assert\GreaterThan(
     *     value = 1)
     */
    private $prix ;
    /**
     * @ORM\Column(type="integer")
     */
    private $quantite ;



    /**
     * @return mixed
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @return mixed
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * @param mixed $quantite
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
    }

    /**
     * @param mixed $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }



    /**
     * @Assert\File(maxSize="5k")
     */
    public $file;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Ajouter une image jpg")
     * @Assert\File(mimeTypes={ "image/jpeg" })
     */
    private $image ;
    /**
     * @ORM\Column(type="string")
     */
    private $reference;

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }





    /**
     * @return mixed
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param mixed $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    public function notificationsOnCreate(NotificationBuilder $builder)
    {
        $notification = new Notification();
        $notification
            ->setTitle('Nouveau Produit ajouter')
            ->setDescription($this->getNom())
            ->setRoute('detail_produit')
            ->setParameters(array('id' => $this->id))
        ;
        $builder->addNotification($notification);

        return $builder;
    }

    public function notificationsOnUpdate(NotificationBuilder $builder)
    {
        $notification = new Notification();
        $notification
            ->setTitle('Modification de produit')
            ->setDescription($this->getNom())
            ->setRoute('detail_produit')
            ->setParameters(array('id' => $this->id))
        ;
        $builder->addNotification($notification);

        return $builder;
    }

    public function notificationsOnDelete(NotificationBuilder $builder)
    {
        // in case you don't want any notification for a special event
        // you can simply return an empty $builder
        return $builder;
    }




}

