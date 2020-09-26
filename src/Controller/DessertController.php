<?php

namespace App\Controller;

use App\Entity\Dessert;
use App\Entity\Ingredient;
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
     * @Route("/featured", name="dessert_show", methods={"GET"})
     */
    public function show(DessertRepository $dessertRepository): Response
    {
        $dessertList = $dessertRepository->findObsoleteList();
        $entityManager = $this->getDoctrine()->getManager();
        $yesterday = new \DateTime();;
        date_sub($yesterday,date_interval_create_from_date_string("1 days"));
        $dayBeforeYesterday = new \DateTime();;
        date_sub($dayBeforeYesterday,date_interval_create_from_date_string("2 days"));
        $yesterday_dt = $yesterday->format('Y-m-d');
        $dayBeforeYesterday_dt = $dayBeforeYesterday->format('Y-m-d');

        foreach ($dessertList as $key => $value){
            $value->setObsolete(true);
            $entityManager->persist($value);

        }
        $entityManager->flush();

        $dessertList = $dessertRepository->findFeaturedList();

        foreach ($dessertList as $key => $value){
            if($value->getDateSell()->format('Y-m-d') == $yesterday_dt){
                $price = floatval( $value->getPrice() ) * (80/100);
                $value->setPrice(number_format($price,2));
            }elseif ($value->getDateSell()->format('Y-m-d') == $dayBeforeYesterday_dt){
                $price = floatval( $value->getPrice() ) * (20/100);
                $value->setPrice(number_format($price,2));
            }

        }

        return $this->render('dessert/show.html.twig', [
            'desserts' => $dessertList,
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

            $ingredients = $entityManager->getRepository(Ingredient::class)->findByDessertId($dessert->getId());

            foreach ($ingredients as $key => $value){
                $entityManager->remove($value);
            }


            $entityManager->remove($dessert);
            $entityManager->flush();
        }

        return $this->redirectToRoute('dessert_index');
    }
}
