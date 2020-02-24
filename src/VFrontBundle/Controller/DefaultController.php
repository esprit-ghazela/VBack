<?php

namespace VFrontBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        if (!$session->has('panier'))
        {
            $articles = 0;
        } else {
            $articles = count($session->get('panier'));
        }
        return $this->render('@VFront/Default/index.html.twig',array(
            'articles'=>$articles
        ));
    }

    public function categoryAction()
    {
        return $this->render('@VFront/FrontTemplate/category.html.twig');
    }

}
