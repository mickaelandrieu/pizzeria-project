<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Ingredient;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $ingredients = $this->getDoctrine()
            ->getRepository('AppBundle:Ingredient')
            ->findAll()
        ;

        $pizzas = $this->getDoctrine()
            ->getRepository('AppBundle:Pizza')
            ->findAll()
        ;

        return $this->render('default/index.html.twig', [
            'ingredients' => $ingredients,
            'pizzas' => $pizzas,
        ]);
    }
}
