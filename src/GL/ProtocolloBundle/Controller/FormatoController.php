<?php

namespace GL\ProtocolloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use GL\ProtocolloBundle\Entity\Formato;
use GL\ProtocolloBundle\Form\FormatoType;

/**
 * Formato controller.
 *
 * @Route("/protocollo/formati")
 */
class FormatoController extends Controller
{
    /**
     * Lists all Formato entities.
     *
     * @Route("/", name="protocollo_formato")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('GLProtocolloBundle:Formato')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Formato entity.
     *
     * @Route("/{id}/show", name="protocollo_formato_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GLProtocolloBundle:Formato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Formato entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Formato entity.
     *
     * @Route("/new", name="protocollo_formato_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Formato();
        $form   = $this->createForm(new FormatoType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Formato entity.
     *
     * @Route("/create", name="protocollo_formato_create")
     * @Method("post")
     * @Template("GLProtocolloBundle:Formato:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Formato();
        $request = $this->getRequest();
        $form    = $this->createForm(new FormatoType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('protocollo_formato_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Formato entity.
     *
     * @Route("/{id}/edit", name="protocollo_formato_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GLProtocolloBundle:Formato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Formato entity.');
        }

        $editForm = $this->createForm(new FormatoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Formato entity.
     *
     * @Route("/{id}/update", name="protocollo_formato_update")
     * @Method("post")
     * @Template("GLProtocolloBundle:Formato:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GLProtocolloBundle:Formato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Formato entity.');
        }

        $editForm   = $this->createForm(new FormatoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('protocollo_formato_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Formato entity.
     *
     * @Route("/{id}/delete", name="protocollo_formato_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('GLProtocolloBundle:Formato')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Formato entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('protocollo_formato'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
