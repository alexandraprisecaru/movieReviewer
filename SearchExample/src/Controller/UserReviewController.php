<?php

namespace App\Controller;

use App\Entity\UserReview;
use App\Form\UserReviewType;
use App\Repository\UserReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/review")
 */
class UserReviewController extends AbstractController
{
    /**
     * @Route("/", name="user_review_index", methods="GET")
     */
    public function index(UserReviewRepository $userReviewRepository): Response
    {
        return $this->render('user_review/index.html.twig', ['user_reviews' => $userReviewRepository->findAll()]);
    }

    /**
     * @Route("/new", name="user_review_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $userReview = new UserReview();
        $form = $this->createForm(UserReviewType::class, $userReview);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($userReview);
            $em->flush();

            return $this->redirectToRoute('user_review_index');
        }

        return $this->render('user_review/new.html.twig', [
            'user_review' => $userReview,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_review_show", methods="GET")
     */
    public function show(UserReview $userReview): Response
    {
        return $this->render('user_review/show.html.twig', ['user_review' => $userReview]);
    }

    /**
     * @Route("/{id}/edit", name="user_review_edit", methods="GET|POST")
     */
    public function edit(Request $request, UserReview $userReview): Response
    {
        $form = $this->createForm(UserReviewType::class, $userReview);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_review_index', ['id' => $userReview->getId()]);
        }

        return $this->render('user_review/edit.html.twig', [
            'user_review' => $userReview,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_review_delete", methods="DELETE")
     */
    public function delete(Request $request, UserReview $userReview): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userReview->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($userReview);
            $em->flush();
        }

        return $this->redirectToRoute('user_review_index');
    }
}
