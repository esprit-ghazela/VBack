<?php


namespace GProduitBundle\Controller;

use GProduitBundle\Form\ProduitType;
use GProduitBundle\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProduitController extends Controller
{

    public function ajouterAction(Request $request){
        $produit = new Produit() ;
        $form =$this->createForm(ProduitType::class,$produit);
        $form->HandleRequest($request);
        if ($form->isSubmitted()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();
            return $this->redirectToRoute("gestion_stock") ;
        }
        return $this->render("@GProduit/Produit/ajouter_produit.html.twig",array(
            'form'=>$form->createView()
        ));
    }
    public function afficherAction(Request $request){


        $em = $this->getDoctrine()->getManager();
        $produits=$em->getRepository('GProduitBundle:Produit')->findAll();

        return $this->render('@VBack/Template/gestion_stock.html.twig',array(
            'produits'=>$produits
        ));
    }

    public function singlafficherAction(Request $request)
    {
        $session = $request->getSession();
        $articles = count($session->get('panier'));

        return $this->render('@VFront/FrontTemplate/detail.twig');
    }

    public function modifierAction(Request $request,$id){
        $em=$this->getDoctrine()->getManager();
        $produits=$em->getRepository("GProduitBundle:Produit")->find($id);
        $form=$this->createForm(\GProduitBundle\Form\ProduitType::class,$produits);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $em->persist($produits);
            $em->flush();
            return $this->redirectToRoute("gestion_stock") ;
        }
        return $this->render("@GProduit/Produit/modifier_produit.html.twig",array(
            'form'=>$form->createView()
        ));
    }

    public function supprimerAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository("GProduitBundle:Produit")->find($id);
        $em->remove($produits);
        $em->flush();
        return $this->redirectToRoute("gestion_stock");
    }

    public function detailAction(Request $request,$id)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        $produit=$em->getRepository('GProduitBundle:Produit')->find($id);

        if (!$produit) throw $this->createNotFoundException('La page n\'existe pas.');

        if ($session->has('panier'))
        {
            $panier = $session->get('panier');
        }else{
            $panier = false;
        }

        $articles = count($session->get('panier'));

        return $this->render('@VFront/FrontTemplate/detail.html.twig',array(
            'produit'=>$produit,'panier'=>$panier,'articles' => $articles
        ));
    }


    public  function filter_produitAction(Request $request,$filtre)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        $findProduits=$em->getRepository('GProduitBundle:Produit')->findBy(array("categorie" => $filtre));

        $emc= $this->getDoctrine()->getManager();
        $categorie=$emc->getRepository('GProduitBundle:Categorie')->findAll();
        if ($session->has('panier')) {
            $panier = $session->get('panier');
            $articles = count($session->get('panier'));

        } else {
            $panier = false;
            $articles = 0;
        }
        $produits  = $this->get('knp_paginator')
            ->paginate($findProduits,$request->query->get('page', 1),1);

        return $this->render('@VFront/FrontTemplate/category.html.twig',array(
            'produits'=>$produits,'panier'=>$panier,'filtre_categorie'=>$categorie,'articles' => $articles
        ));
    }

    public  function filtre_marque_produitAction(Request $request,$marque)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        $findProduits=$em->getRepository('GProduitBundle:Produit')->findBy(array("marque" => $marque));

        $emc= $this->getDoctrine()->getManager();
        $categorie=$emc->getRepository('GProduitBundle:Categorie')->findAll();
        if ($session->has('panier')) {
            $panier = $session->get('panier');
            $articles = count($session->get('panier'));

        } else {
            $panier = false;
            $articles = 0;
        }

        $produits  = $this->get('knp_paginator')
            ->paginate($findProduits,$request->query->get('page', 1),1);

        return $this->render('@VFront/FrontTemplate/category.html.twig',array(
            'produits'=>$produits,'panier'=>$panier,'filtre_categorie'=>$categorie,'articles' => $articles
        ));
    }

    public  function trier_prix_croissantAction(Request $request)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        $findProduits=$em->getRepository('GProduitBundle:Produit')->PrixOrdreCroissant();

        $emc= $this->getDoctrine()->getManager();
        $categorie=$emc->getRepository('GProduitBundle:Categorie')->findAll();
        if ($session->has('panier')) {
            $panier = $session->get('panier');
            $articles = count($session->get('panier'));

        } else {
            $panier = false;
            $articles = 0;
        }
        $produits  = $this->get('knp_paginator')
            ->paginate($findProduits,$request->query->get('page', 1),1);

        return $this->render('@VFront/FrontTemplate/category.html.twig',array(
            'produits'=>$produits,'panier'=>$panier,'filtre_categorie'=>$categorie,'articles' => $articles
        ));
    }

    public  function trier_prix_decroissantAction(Request $request)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        $findProduits=$em->getRepository('GProduitBundle:Produit')->PrixOrdreDecroissant();

        $emc= $this->getDoctrine()->getManager();
        $categorie=$emc->getRepository('GProduitBundle:Categorie')->findAll();
        if ($session->has('panier')) {
            $panier = $session->get('panier');
            $articles = count($session->get('panier'));

        } else {
            $panier = false;
            $articles = 0;
        }

        $produits  = $this->get('knp_paginator')
            ->paginate($findProduits,$request->query->get('page', 1),1);

        return $this->render('@VFront/FrontTemplate/category.html.twig',array(
            'produits'=>$produits,'panier'=>$panier,'filtre_categorie'=>$categorie,'articles' => $articles
        ));
    }




}