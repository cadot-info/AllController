<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/all")
 * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_SUPER_ADMIN')")
 */
class AllController extends AbstractController
{

    public function __construct()
    {
    }

    /**
     * @Route("/{part}", name="all_index", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_SUPER_ADMIN')")
     */

    public function index($part): Response
    {
        $alls = count(
            $this->$part->findAll()
        ) ? $this->$part->findAll() : '';
        return $this->render('all/index.html.twig', [
            'alls' => $alls,
            'part' => $part
        ]);
    }

    /**
     * @Route("/new/{part}", name="all_new", methods={"GET","POST"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_SUPER_ADMIN')")
     */
    public function new(Request $request, $part): Response
    {
        $Call = 'App\\Entity\\' . ucfirst($part);
        $Call = new $Call();
        $form = $this->createForm('App\\Form\\' . ucfirst($part) . 'Type'::class, $Call);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($Call);
            $entityManager->flush();

            return $this->redirectToRoute('all_index', ['part' => $part]);
        }

        return $this->render('all/new.html.twig', [
            'part' => $part,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/{part}", name="all_show", methods={"GET"}, requirements={"id"="\d+"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_SUPER_ADMIN')")
     */
    public function show($id, $part): Response
    {

        return $this->render('all/show.html.twig', [
            'all' => $this->$part->findOneBy(['id' => $id]),
            'part' => $part
        ]);
    }


    /**
     * @Route("/edit/{id}/{part}", name="all_edit", methods={"GET","POST"}, requirements={"id"="\d+"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_SUPER_ADMIN')")
     */
    public function edit(Request $request, $id, $part): Response
    {
        $Call = $this->$part->findOneBy(['id' => $id]);
        $form = $this->createForm('App\\Form\\' . ucfirst($part) . 'Type'::class, $Call);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('all_index', ['part' => $part]);
        }

        return $this->render('all/edit.html.twig', [
            'all' => $this->$part->findOneBy(['id' => $id]),
            'part' => $part,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="all_delete", methods={"DELETE"}, requirements={"id"="\d+"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_SUPER_ADMIN')")
     */
    public function delete(Request $request, $id): Response
    {
        $part = $request->query->get('part');
        $Call = $this->$part->findOneBy(['id' => $id]);
        if ($this->isCsrfTokenValid('delete' . $Call->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($Call);
            $entityManager->flush();
        }

        return $this->redirectToRoute('all_index', ['part' => $part]);
    }
    public function &factory($className)
    {

        if (class_exists($className)) return new $className;
        die('Cannot create new "' . $className . '" class - includes not found or class unavailable.');
    }
}
