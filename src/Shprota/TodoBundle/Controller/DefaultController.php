<?php

namespace Shprota\TodoBundle\Controller;

//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Shprota\TodoBundle\Entity\Item;
use Symfony\Component\Validator\Constraints\DateTime;

class DefaultController extends FOSRestController
{
	public function indexAction()
	{
		return $this->render('ShprotaTodoBundle:Default:index.html.twig');
	}
}
