<?php


namespace UserBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    public function afficherAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $admins=$em->getRepository('UserBundle:User')->RoleAdmin();

        return $this->render('@VBack/Template/gestion_administrateur.html.twig',array(
            'admins'=>$admins
        ));
    }


}