<?php


namespace GProduitBundle\Data;


use GProduitBundle\Entity\Categorie;

class SearchData
{
    /**
     * @var string
     */
    public $q = '' ;
    /**
     * @var Categorie[]
     */
    public $categorie = [] ;
    /**
     * @var null|integer
     */
    public $max ;
    /**
     * @var null|integer
     */
    public  $min ;

}