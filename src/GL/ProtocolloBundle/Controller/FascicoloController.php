<?php

namespace GL\ProtocolloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use GL\ProtocolloBundle\Entity\Fascicolo;
use GL\ProtocolloBundle\Form\FascicoloType;

/**
 * Fascicolo controller.
 *
 * @Route("/protocollo/fascicoli")
 */
class FascicoloController extends Controller
{
    /**
     * Lists all Fascicolo entities.
     *
     * @Route("/", name="protocollo_fascicolo")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('GLProtocolloBundle:Fascicolo')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Fascicolo entity.
     *
     * @Route("/{id}/show", name="protocollo_fascicolo_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GLProtocolloBundle:Fascicolo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fascicolo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Fascicolo entity.
     *
     * @Route("/new", name="protocollo_fascicolo_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Fascicolo();
        $form   = $this->createForm(new FascicoloType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Fascicolo entity.
     *
     * @Route("/create", name="protocollo_fascicolo_create")
     * @Method("post")
     * @Template("GLProtocolloBundle:Fascicolo:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Fascicolo();
        $request = $this->getRequest();
        $form    = $this->createForm(new FascicoloType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('protocollo_fascicolo_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Fascicolo entity.
     *
     * @Route("/{id}/edit", name="protocollo_fascicolo_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GLProtocolloBundle:Fascicolo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fascicolo entity.');
        }

        $editForm = $this->createForm(new FascicoloType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Fascicolo entity.
     *
     * @Route("/{id}/update", name="protocollo_fascicolo_update")
     * @Method("post")
     * @Template("GLProtocolloBundle:Fascicolo:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GLProtocolloBundle:Fascicolo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fascicolo entity.');
        }

        $editForm   = $this->createForm(new FascicoloType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('protocollo_fascicolo_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Fascicolo entity.
     *
     * @Route("/{id}/delete", name="protocollo_fascicolo_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('GLProtocolloBundle:Fascicolo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Fascicolo entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('protocollo_fascicolo'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
