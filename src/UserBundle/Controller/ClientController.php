<?php


namespace UserBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ClientController extends  Controller
{
    public function afficherAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $clients=$em->getRepository('UserBundle:User')->RoleClient();

        return $this->render('@VBack/Template/gestion_client.html.twig',array(
            'clients'=>$clients
        ));
    }

}