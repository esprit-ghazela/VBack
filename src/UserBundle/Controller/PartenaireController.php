<?php


namespace UserBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PartenaireController extends Controller
{
    public function afficherAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $role='ROLE_PART';
        $partenaires=$em->getRepository('UserBundle:User')->RolePart($role);

        return $this->render('@VBack/Template/gestion_partenaire.html.twig',array(
            'partenaires'=>$partenaires
        ));
    }

    public function inscriptionAction(Request $request)
    {
        return $this->render('@User/Partenaire/register_partenaire.html.twig');
    }







}