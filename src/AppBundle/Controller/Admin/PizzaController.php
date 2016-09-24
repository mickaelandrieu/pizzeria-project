<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Pizza;
use AppBundle\Form\PizzaType;

/**
 * @Route("/admin/pizza")
 */
class PizzaController extends Controller
{
    /**
     * @Route("/", name="pizza_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pizzas = $em->getRepository('AppBundle:Pizza')->findAll();

        return $this->render('admin/pizza/index.html.twig', array(
            'pizzas' => $pizzas,
        ));
    }

    /**
     * @Route("/new", name="pizza_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $pizza = new Pizza();
        $form = $this->createForm(PizzaType::class, $pizza);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pizza);
            $em->flush();

            return $this->redirectToRoute('pizza_show', array('id' => $pizza->getId()));
        }

        return $this->render('admin/pizza/new.html.twig', array(
            'pizza' => $pizza,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}", name="pizza_show")
     * @Method("GET")
     */
    public function showAction(Pizza $pizza)
    {
        $deleteForm = $this->createDeleteForm($pizza);

        return $this->render('admin/pizza/show.html.twig', array(
            'pizza' => $pizza,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @Route("/{id}/edit", name="pizza_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Pizza $pizza)
    {
        $deleteForm = $this->createDeleteForm($pizza);
        $editForm = $this->createForm(PizzaType::class, $pizza);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pizza);
            $ingredients = $pizza->getIngredients();

            foreach ($ingredients as $ingredient) {
                $em->persist($ingredient);
            }
            $em->flush();

            return $this->redirectToRoute('pizza_edit', array('id' => $pizza->getId()));
        }

        return $this->render('admin/pizza/edit.html.twig', array(
            'pizza' => $pizza,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @Route("/{id}", name="pizza_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Pizza $pizza)
    {
        $form = $this->createDeleteForm($pizza);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pizza);
            $em->flush();
        }

        return $this->redirectToRoute('pizza_index');
    }

    private function createDeleteForm(Pizza $pizza)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pizza_delete', array('id' => $pizza->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
