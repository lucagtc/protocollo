<?php

namespace GL\ProtocolloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use GL\ProtocolloBundle\Entity\Classificazione;
use GL\ProtocolloBundle\Form\ClassificazioneType;

/**
 * Classificazione controller.
 *
 * @Route("/protocollo/classificazioni")
 */
class ClassificazioneController extends Controller
{
    /**
     * Lists all Classificazione entities.
     *
     * @Route("/", name="protocollo_classificazione")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('GLProtocolloBundle:Classificazione')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Classificazione entity.
     *
     * @Route("/{id}/show", name="protocollo_classificazione_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GLProtocolloBundle:Classificazione')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Classificazione entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Classificazione entity.
     *
     * @Route("/new", name="protocollo_classificazione_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Classificazione();
        $form   = $this->createForm(new ClassificazioneType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Classificazione entity.
     *
     * @Route("/create", name="protocollo_classificazione_create")
     * @Method("post")
     * @Template("GLProtocolloBundle:Classificazione:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Classificazione();
        $request = $this->getRequest();
        $form    = $this->createForm(new ClassificazioneType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('protocollo_classificazione_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Classificazione entity.
     *
     * @Route("/{id}/edit", name="protocollo_classificazione_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GLProtocolloBundle:Classificazione')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Classificazione entity.');
        }

        $editForm = $this->createForm(new ClassificazioneType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Classificazione entity.
     *
     * @Route("/{id}/update", name="protocollo_classificazione_update")
     * @Method("post")
     * @Template("GLProtocolloBundle:Classificazione:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GLProtocolloBundle:Classificazione')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Classificazione entity.');
        }

        $editForm   = $this->createForm(new ClassificazioneType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('protocollo_classificazione_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Classificazione entity.
     *
     * @Route("/{id}/delete", name="protocollo_classificazione_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('GLProtocolloBundle:Classificazione')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Classificazione entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('protocollo_classificazione'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
