<?php


namespace UserBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PartenaireController extends Controller
{
    public function afficherAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $partenaires=$em->getRepository('GProduitBundle:Produit')->findByRolePart();

        return $this->render('@VBack/Template/gestion_partenaire.html.twig',array(
            'partenaires'=>$partenaires
        ));
    }





}