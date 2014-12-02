<?php

namespace Shprota\TodoBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Shprota\TodoBundle\Entity\Item;
use Shprota\TodoBundle\Form\ItemType;

class ItemController extends FOSRestController implements ClassResourceInterface
{
	public function cgetAction()
	{
		$items = $this->getDoctrine()->getRepository('ShprotaTodoBundle:Item')->findAll();
		$view = $this->view($items);
		$view->setFormat('json');
		return $this->handleView($view);
	}

	public function getAction($slug)
	{
		$item = $this->getDoctrine()->getRepository('ShprotaTodoBundle:Item')->find($slug);
		$view = $this->view($item);
		$view->setFormat('json');
		return $this->handleView($view);
	}

	public function postAction()
	{
		$item = new Item;
		return $this->saveItem($item);
	}

	public function putAction($slug)
	{
		$em = $this->getDoctrine()->getManager();
		/** @var \Shprota\TodoBundle\Entity\Item $item */
		$item = $em->getRepository('ShprotaTodoBundle:Item')->find($slug);
		if (!$item) {
			throw $this->createNotFoundException('Unable to find Item.');
		}
		return $this->saveItem($item);
	}

	public function deleteAction($slug)
	{
		$em = $this->getDoctrine()->getManager();
		$item = $em->getRepository('ShprotaTodoBundle:Item')->find($slug);
		if (!$item) {
			throw $this->createNotFoundException('Unable to find Item.');
		}
		$em->remove($item);
		$em->flush();
		$view = $this->view(['success' => true])->setFormat('json');
		return $this->handleView($view);
	}

	/**
	 * In case of backbone.js communication, the objects are always sent in the whole.
	 * Thus the save method is common for POST and PUT.
	 * @param \Shprota\TodoBundle\Entity\Item $item - entity to save
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	private function saveItem(&$item)
	{
		// Decode the request JSON data
		$encoder = new JsonEncoder();
		$data = $encoder->decode($this->get('request')->getContent(), 'array');

		$form = $this->createForm(new ItemType(), $item, ['method' => 'PUT']);
		$form->submit($data);
		if (!$form->isValid()) {
			$view = $this->view(['success' => false, 'error' => $form->getErrors(true, true)])->setFormat('json');
			$view->setStatusCode(500);
			return $this->handleView($view);
		}
		$em = $this->getDoctrine()->getManager();
		$em->persist($item);
		$em->flush();
		$view = $this->view($item)->setFormat('json');
		return $this->handleView($view);
	}
}
