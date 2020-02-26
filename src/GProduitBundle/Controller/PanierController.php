<?php


namespace GProduitBundle\Controller;


use GProduitBundle\Data\SearchData;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse ;
use Symfony\Component\HttpFoundation\Request;

class PanierController extends Controller
{

    public function afficherAction(Request $request){
        $data = new SearchData();

        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        $findProduits=$em->getRepository('GProduitBundle:Produit')->findAll();

        $emc= $this->getDoctrine()->getManager();
        $categorie=$emc->getRepository('GProduitBundle:Categorie')->findAll();


        if ($session->has('panier')) {
            $panier = $session->get('panier');
            $articles = count($session->get('panier'));

        } else {
            $panier = false;
            $articles = 0;
        }

        if ($request->isMethod('POST')) {
            $nom = $request->get('nom');
            $produits = $em->getRepository("GProduitBundle:Produit")->findBy(array("nom" => $nom));
        }
        $produits  = $this->get('knp_paginator')
            ->paginate($findProduits,$request->query->get('page', 1),1);

        return $this->render('@VFront/FrontTemplate/category.html.twig',array(
            'produits'=>$produits,'panier'=>$panier,'filtre_categorie'=>$categorie,'articles' => $articles
        ));
    }

    public function ajouterpanierAction(Request $request,$id)
    {
        $session = $request->getSession();

        if (!$session->has('panier')) $session->set('panier', array());
        $panier = $session->get('panier');

        if (array_key_exists($id, $panier)) {
            if ($request->query->get('quantite') != null) $panier[$id] = $request->query->get('quantite');
            $this->get('session')->getFlashBag()->add('success', 'Quantité modifié avec succès');
        } else {
            if ($request->query->get('quantite') != null) {
                $panier[$id] = $request->query->get('quantite');
            } else {
                $panier[$id] = 1;
            }
            $this->get('session')->getFlashBag()->add('success', 'Article ajouté avec succès');
        }

        $session->set('panier', $panier);

        return $this->redirect($this->generateUrl('panier'));

    }

    public function panierAction(Request $request)
    {
        $session = $request->getSession();
        // var_dump($session->get('panier'));
        // die();
        if (!$session->has('panier'))
        {
            $session->set('panier',array());
            $articles = count($session->get('panier'));
        }
        $articles = count($session->get('panier'));
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('GProduitBundle:Produit')->findArray(array_keys($session->get('panier')));

        return $this->render('@VFront/FrontTemplate/cart.html.twig',array('produits' => $produits,
            'panier' => $session->get('panier'),'articles' => $articles) );
    }

    public function supprimerpanierpAction(Request $request,$id)
    {
        $session = $request->getSession();
        $panier = $session->get('panier');

        if (array_key_exists($id, $panier))
        {
            unset($panier[$id]);
            $session->set('panier',$panier);
            $this->get('session')->getFlashBag()->add('success','Article supprimé avec succès');
        }

        return $this->redirect($this->generateUrl('panier'));
    }

    public function menuAction(Request $request)
    {
        $session = $request->getSession();
        if (!$session->has('panier'))
        {
            $articles = 0;
        } else {
            $articles = count($session->get('panier'));
        }
        return $this->render('@app\Resources\views\front_base.html.twig', array('articles' => $articles));
    }




}