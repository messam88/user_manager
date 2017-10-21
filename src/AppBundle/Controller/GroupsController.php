<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Group;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Group controller.
 *
 * @Route("admin/groups")
 */
class GroupsController extends Controller {

    /**
     * Lists all group entities.
     *
     * @Route("/", name="groups_index")
     * @Method("GET")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $groups = $em->getRepository('AppBundle:Group')->findAll();
        return $this->render('AppBundle:groups:index.html.twig', array (
                    'groups' => $groups,
        ));
    }

    /**
     * Creates a new group entity.
     *
     * @Route("/new", name="groups_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request) {
        $group = new Group();
        $form = $this->createForm('AppBundle\Form\GroupsType', $group);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($group);
            $em->flush();
            $this->addFlash('success', 'New group added successfully');
            return $this->redirectToRoute('groups_index');
        }

        return $this->render('AppBundle:groups:new.html.twig', array (
                    'group' => $group,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a group entity.
     *
     * @Route("/show/{id}", name="groups_show")
     * @Method("GET")
     */
    public function showAction(Group $group) {
        return $this->render('AppBundle:groups:show.html.twig', array (
                    'group' => $group
        ));
    }

    /**
     * Displays a form to edit an existing group entity.
     *
     * @Route("/edit/{id}", name="groups_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Group $group) {
        $editForm = $this->createForm('AppBundle\Form\GroupsType', $group);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Group updated successfully');
            return $this->redirectToRoute('groups_index');
        }
        return $this->render('AppBundle:groups:edit.html.twig', array (
                    'group' => $group,
                    'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a group entity.
     *
     * @Route("/delete/{id}", name="groups_delete")
     * 
     */
    public function deleteAction(Group $group) {
        if (count($group->getUsers()) == 0) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($group);
            $em->flush();
            $this->addFlash('success', 'Group deleted successfully');
        } else {
            $this->addFlash('danger', 'Group can not be deleted, it has attached users.');
        }
        return $this->redirectToRoute('groups_index');
    }

}
