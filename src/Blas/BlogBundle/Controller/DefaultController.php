<?php

namespace Blas\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BlasBlogBundle:Default:index.html.twig', array('name' => $name));
    }
}
