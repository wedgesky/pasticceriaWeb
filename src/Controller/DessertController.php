<?php

namespace App\Controller;

use App\Entity\Dessert;
use App\Form\DessertType;
use App\Repository\DessertRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dessert")
 */
class DessertController extends AbstractController
{
    /**
     * @Route("/", name="dessert_index", methods={"GET"})
     */
    public function index(DessertRepository $dessertRepository): Response
    {
        return $this->render('dessert/index.html.twig', [
            'desserts' => $dessertRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="dessert_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $dessert = new Dessert();
        $form = $this->createForm(DessertType::class, $dessert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($dessert);
            $entityManager->flush();

            return $this->redirectToRoute('dessert_index');
        }

        return $this->render('dessert/new.html.twig', [
            'dessert' => $dessert,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="dessert_show", methods={"GET"})
     */
    public function show(Dessert $dessert): Response
    {
        return $this->render('dessert/show.html.twig', [
            'dessert' => $dessert,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="dessert_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Dessert $dessert): Response
    {
        $form = $this->createForm(DessertType::class, $dessert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dessert_index');
        }

        return $this->render('dessert/edit.html.twig', [
            'dessert' => $dessert,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="dessert_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Dessert $dessert): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dessert->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($dessert);
            $entityManager->flush();
        }

        return $this->redirectToRoute('dessert_index');
    }
}
