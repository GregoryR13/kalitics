<?php

namespace App\Controller;

use App\Entity\Chantiers;
use App\Entity\Pointages;
use App\Entity\Users;
use App\Form\ChantiersFormType;
use App\Form\PointagesFormType;
use App\Form\UsersFormType;
use App\Repository\PointagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('index.html.twig', [
            'controller_name' => 'Home',
        ]);
    }

    /**
     * @Route("/utilisateurs", name="users")
     * @param Request $request
     * @return Response
     */
    public function displayUsers(Request $request): Response
    {
        $entity = new users();

        $form = $this->createForm(UsersFormType::class, $entity);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $addManager = $this->getDoctrine()->getManager();
            $addManager->persist($entity);
            $addManager->flush();

            return $this->redirectToRoute("users");
        }

        $users = $this->getDoctrine()->getRepository(Users::class)->findAll();

        return $this->render('users.html.twig', [
            'formUsers' => $form->createView(),
            'users' => $users,
        ]);
    }

    /**
     * @Route("/useredit/{id}", name="editUser")
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function editUser(Request $request, int $id): Response
    {
        $editManager = $this->getDoctrine()->getManager();

        $user = $editManager->getRepository(Users::class)->find($id);
        $form = $this->createForm(UsersFormType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $editManager->flush();

            return $this->redirectToRoute("users");
        }

        return $this->render("users-edit.html.twig", [
            "formUser" => $form->createView(),
        ]);
    }

    /**
     * @Route("/deluser/{id}", name="delUser")
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function delUser(Request $request, int $id): Response
    {
        $delManager = $this->getDoctrine()->getManager();

        $user = $delManager->getRepository(Users::class)->find($id);
        $delManager->remove($user);
        $delManager->flush();

        return $this->redirectToRoute("users");
    }

    /**
     * @Route("/chantiers", name="chantiers")
     * @param Request $request
     * @return Response
     */
    public function displayChantiers(Request $request): Response
    {
        $entity = new chantiers();

        $form = $this->createForm(ChantiersFormType::class, $entity);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $addManager = $this->getDoctrine()->getManager();
            $addManager->persist($entity);
            $addManager->flush();

            return $this->redirectToRoute("chantiers");
        }

        $chantiers = $this->getDoctrine()->getRepository(Chantiers::class)->findAll();
        $pointersByChantier =  $this->getDoctrine()->getRepository(Pointages::class)->findPointersDistinctByChantier();
        $dureesByChantier = $this->getDoctrine()->getRepository(Pointages::class)->findDureeCumuleeByChantier();

        return $this->render('chantiers.html.twig', [
            'formChantiers' => $form->createView(),
            'chantiers' => $chantiers,
            'pointersByChantier' => $pointersByChantier,
            'dureesByChantier' => $dureesByChantier
        ]);
    }

    /**
     * @Route("/chantieredit/{id}", name="editChantier")
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function editChantier(Request $request, int $id): Response
    {
        $editManager = $this->getDoctrine()->getManager();

        $chantier = $editManager->getRepository(Chantiers::class)->find($id);
        $form = $this->createForm(ChantiersFormType::class, $chantier);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $editManager->flush();

            return $this->redirectToRoute("chantiers");
        }

        return $this->render("chantiers-edit.html.twig", [
            "formChantier" => $form->createView(),
        ]);
    }

    /**
     * @Route("/delchantier/{id}", name="delChantier")
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function delChantier(Request $request, int $id): Response
    {
        $delManager = $this->getDoctrine()->getManager();

        $chantier = $delManager->getRepository(Chantiers::class)->find($id);
        $delManager->remove($chantier);
        $delManager->flush();

        return $this->redirectToRoute("chantiers");
    }

    /**
     * @Route("/pointages", name="pointages")
     * @param Request $request
     * @return Response
     */
    public function displayPointages(Request $request): Response
    {
        $entity = new pointages();

        $form = $this->createForm(PointagesFormType::class, $entity);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $addManager = $this->getDoctrine()->getManager();
            $addManager->persist($entity);
            $addManager->flush();

            return $this->redirectToRoute("pointages");
        }

        //dd($this->getDoctrine()->getRepository(Pointages::class)->findAllByJointure());
        $pointages = $this->getDoctrine()->getRepository(Pointages::class)->findAll();

        return $this->render('pointages.html.twig', [
            'formPointages' => $form->createView(),
            'pointages' => $pointages,
        ]);
    }

    /**
     * @Route("/pointageedit/{id}", name="editPointage")
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function editPointage(Request $request, int $id): Response
    {
        $editManager = $this->getDoctrine()->getManager();

        $pointage = $editManager->getRepository(Pointages::class)->find($id);
        $form = $this->createForm(PointagesFormType::class, $pointage);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $editManager->flush();

            return $this->redirectToRoute("pointages");
        }

        return $this->render("pointages-edit.html.twig", [
            "formPointage" => $form->createView(),
        ]);
    }

    /**
     * @Route("/delpointage/{id}", name="delPointage")
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function delPointage(Request $request, int $id): Response
    {
        $delManager = $this->getDoctrine()->getManager();

        $pointage = $delManager->getRepository(Pointages::class)->find($id);
        $delManager->remove($pointage);
        $delManager->flush();

        return $this->redirectToRoute("pointages");
    }

}
