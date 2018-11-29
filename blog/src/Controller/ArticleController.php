<?php
    namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class ArticleController extends Controller {
    /**
     * @Route("/")
     * @Method({"GET"})
     */
    public function index() {
     
    $blogposts = ['blog1', 'blog2'];

     return $this->render('blog/index.html.twig', array
     ('blogposts' => $blogposts));
    }
}

