<?php


namespace GProduitBundle\Controller;

use GProduitBundle\Form\ProduitType;
use GProduitBundle\Entity\Produit;
use GProduitBundle\Entity\Notifications ;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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

            return $this->redirectToRoute("ajouter_produit") ;
        }
        $notification=$this->getDoctrine()->getManager()->getRepository('GProduitBundle:Notification')->findAll() ;

        return $this->render("@GProduit/Produit/ajouter_produit.html.twig",array(
            'form'=>$form->createView(),'notification' => $notification
        ));
    }
    public function afficherAction(Request $request,$user_id){
        $em = $this->getDoctrine()->getManager();
        $produits=$em->getRepository('GProduitBundle:Produit')->findbyUser($user_id);
        $notification=$this->getDoctrine()->getManager()->getRepository('GProduitBundle:Notification')->findAll() ;

        return $this->render('@VBack/Template/gestion_stock.html.twig',array(
            'produits'=>$produits,'notification' => $notification
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
            return $this->redirectToRoute("accuil") ;
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
        return $this->redirectToRoute("accuil");
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
            $articles = count($session->get('panier'));
        }else{
            $panier = false;
            $articles = 0;
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
            ->paginate($findProduits,$request->query->get('page', 1),5);

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
            ->paginate($findProduits,$request->query->get('page', 1),5);

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
            ->paginate($findProduits,$request->query->get('page', 1),5);

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
            ->paginate($findProduits,$request->query->get('page', 1),5);

        return $this->render('@VFront/FrontTemplate/category.html.twig',array(
            'produits'=>$produits,'panier'=>$panier,'filtre_categorie'=>$categorie,'articles' => $articles
        ));
    }

    public function detail_produitAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $produit=$em->getRepository('GProduitBundle:Produit')->find($id);

        if (!$produit) throw $this->createNotFoundException('La page n\'existe pas.');


        return $this->render('@GProduit/Produit/detail.html.twig',array(
            'produit'=>$produit
        ));
    }


    public function rechercheProduitAction(Request $request)
    {
        //var_dump($request->getRequestFormat());
        $produit = new Produit();
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository("GProduitBundle:Produit")->findAll();


            $serializer = new Serializer(array(new ObjectNormalizer()));
            $produit = $em->getRepository("GProduitBundle:Produit")
                ->RechercheNom($request->get('nom'));
            $data = $serializer->normalize($produit);
            return new JsonResponse($data);


    }

    public function rechercheAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $nom = $em->getRepository("GProduitBundle:Produit")->findAll();
        if ($request->isMethod('POST')) {
            $nom = $request->get('nom');
            $produit = $em->getRepository("GProduitBundle:Produit")->findBy(array("nom" => $nom));
        }
        else {
            $formation = $this->getDoctrine()->getRepository(Produit::class)
                ->findAll();
        }
        return $this->render("@VBack/Produit/category.html.twig", array('formations' => $formations));
    }





}