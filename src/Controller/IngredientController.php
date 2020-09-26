<?php

namespace App\Controller;

use App\Entity\Dessert;
use App\Entity\Ingredient;
use App\Form\IngredientType;
use App\Repository\IngredientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ingredient")
 */
class IngredientController extends AbstractController
{
    /**
     * @Route("/{id}", name="ingredient_index", methods={"GET"})
     */
    public function index($id, IngredientRepository $ingredientRepository): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $dessert = $entityManager->getRepository(Dessert::class)->findOneById($id);

        return $this->render('ingredient/index.html.twig', [
            'ingredients' => $ingredientRepository->findByDessertId($id),
            'dessert' =>  $dessert
        ]);
    }

    /**
     * @Route("/new/{id}", name="ingredient_new", methods={"GET","POST"})
     */
    public function new(Dessert  $dessert, Request $request): Response
    {
        $ingredient = new Ingredient();
        $entityManager = $this->getDoctrine()->getManager();

        $ingredient->setDessert($dessert);

//        if($id){
//            $dessert = $entityManager->getRepository(Dessert::class)->findOneById($id);
//
//            $ingredient->setDessert($dessert);
//        }


        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ingredient);
            $entityManager->flush();

            return $this->redirectToRoute('ingredient_index', ['id' => $dessert->getId()]);
        }

        return $this->render('ingredient/new.html.twig', [
            'ingredient' => $ingredient,
            'form' => $form->createView(),
            'dessert' => $dessert
        ]);
    }

    /**
     * @Route("/{id}", name="ingredient_show", methods={"GET"})
     */
    public function show(Ingredient $ingredient): Response
    {
        return $this->render('ingredient/show.html.twig', [
            'ingredient' => $ingredient,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ingredient_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Ingredient $ingredient, Dessert  $dessert): Response
    {
        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ingredient_index', ['id' => $dessert->getId()]);
        }

        return $this->render('ingredient/edit.html.twig', [
            'ingredient' => $ingredient,
            'form' => $form->createView(),
            'dessert' => $dessert
        ]);
    }

    /**
     * @Route("/{id}", name="ingredient_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Ingredient $ingredient, Dessert $dessert): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ingredient->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ingredient);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ingredient_index', ['id' => $dessert->getId()]);
    }
}
