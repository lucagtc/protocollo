<?php

namespace GL\ProtocolloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use GL\ProtocolloBundle\Entity\Categoria;
use GL\ProtocolloBundle\Form\CategoriaType;

/**
 * Categoria controller.
 *
 * @Route("/protocollo/categorie")
 */
class CategoriaController extends Controller
{
    /**
     * Lists all Categoria entities.
     *
     * @Route("/", name="protocollo_categoria")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('GLProtocolloBundle:Categoria')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Categoria entity.
     *
     * @Route("/{id}/show", name="protocollo_categoria_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GLProtocolloBundle:Categoria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Categoria entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Categoria entity.
     *
     * @Route("/new", name="protocollo_categoria_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Categoria();
        $form   = $this->createForm(new CategoriaType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Categoria entity.
     *
     * @Route("/create", name="protocollo_categoria_create")
     * @Method("post")
     * @Template("GLProtocolloBundle:Categoria:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Categoria();
        $request = $this->getRequest();
        $form    = $this->createForm(new CategoriaType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('protocollo_categoria_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Categoria entity.
     *
     * @Route("/{id}/edit", name="protocollo_categoria_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GLProtocolloBundle:Categoria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Categoria entity.');
        }

        $editForm = $this->createForm(new CategoriaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Categoria entity.
     *
     * @Route("/{id}/update", name="protocollo_categoria_update")
     * @Method("post")
     * @Template("GLProtocolloBundle:Categoria:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GLProtocolloBundle:Categoria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Categoria entity.');
        }

        $editForm   = $this->createForm(new CategoriaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('protocollo_categoria_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Categoria entity.
     *
     * @Route("/{id}/delete", name="protocollo_categoria_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('GLProtocolloBundle:Categoria')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Categoria entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('protocollo_categoria'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
