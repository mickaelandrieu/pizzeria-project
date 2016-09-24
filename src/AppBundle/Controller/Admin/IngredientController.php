<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Ingredient;
use AppBundle\Form\IngredientType;

/**
 * @Route("/admin/ingredient")
 */
class IngredientController extends Controller
{
    /**
     * @Route("/", name="ingredient_index")
     * @Method("GET")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ingredients = $em->getRepository('AppBundle:Ingredient')->findAll();

        return $this->render('admin/ingredient/index.html.twig', array(
            'ingredients' => $ingredients,
        ));
    }

    /**
     * @Route("/new", name="ingredient_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $ingredient = new Ingredient();
        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ingredient);
            $em->flush();

            return $this->redirectToRoute('ingredient_show', array('id' => $ingredient->getId()));
        }

        return $this->render('admin/ingredient/new.html.twig', array(
            'ingredient' => $ingredient,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}", name="ingredient_show")
     * @Method("GET")
     */
    public function showAction(Ingredient $ingredient)
    {
        $deleteForm = $this->createDeleteForm($ingredient);

        return $this->render('admin/ingredient/show.html.twig', array(
            'ingredient' => $ingredient,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @Route("/{id}/edit", name="ingredient_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Ingredient $ingredient)
    {
        $deleteForm = $this->createDeleteForm($ingredient);
        $editForm = $this->createForm(IngredientType::class, $ingredient);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ingredient);
            $em->flush();

            return $this->redirectToRoute('ingredient_edit', array('id' => $ingredient->getId()));
        }

        return $this->render('admin/ingredient/edit.html.twig', array(
            'ingredient' => $ingredient,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @Route("/{id}", name="ingredient_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Ingredient $ingredient)
    {
        $form = $this->createDeleteForm($ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ingredient);
            $em->flush();
        }

        return $this->redirectToRoute('ingredient_index');
    }

    private function createDeleteForm(Ingredient $ingredient)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ingredient_delete', array('id' => $ingredient->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
