<?php

namespace GL\ProtocolloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use GL\ProtocolloBundle\Entity\Protocollo;
use GL\ProtocolloBundle\Form\ProtocolloType;

/**
 * Protocollo controller.
 *
 * @Route("/protocollo")
 */
class ProtocolloController extends Controller
{
    /**
     * Lists all Protocollo entities.
     *
     * @Route("/", name="protocollo")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('GLProtocolloBundle:Protocollo')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Protocollo entity.
     *
     * @Route("/{id}/show", name="protocollo_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GLProtocolloBundle:Protocollo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Protocollo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Protocollo entity.
     *
     * @Route("/new", name="protocollo_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Protocollo();
        $form   = $this->createForm(new ProtocolloType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Protocollo entity.
     *
     * @Route("/create", name="protocollo_create")
     * @Method("post")
     * @Template("GLProtocolloBundle:Protocollo:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Protocollo();
        $request = $this->getRequest();
        $form    = $this->createForm(new ProtocolloType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('protocollo_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Protocollo entity.
     *
     * @Route("/{id}/edit", name="protocollo_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GLProtocolloBundle:Protocollo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Protocollo entity.');
        }

        $editForm = $this->createForm(new ProtocolloType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Protocollo entity.
     *
     * @Route("/{id}/update", name="protocollo_update")
     * @Method("post")
     * @Template("GLProtocolloBundle:Protocollo:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GLProtocolloBundle:Protocollo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Protocollo entity.');
        }

        $editForm   = $this->createForm(new ProtocolloType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('protocollo_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Protocollo entity.
     *
     * @Route("/{id}/delete", name="protocollo_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('GLProtocolloBundle:Protocollo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Protocollo entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('protocollo'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
