<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Entity\Author;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Session\Session;

use App\Form\AuthorFormType;


class AdminController extends AbstractController {

    private $entityManager;

    private $authorRepository;

    private $blogPostRepository;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
        $this->blogPostRepository = $entityManager->getRepository('App:BlogPost');
        $this->authorRepository = $entityManager->getRepository('App:Author');
    }


    /**
     * @Route("/admin/create", name="author_create")
     * @Method({"GET", "POST"})
     */
    public function createAuthor(Request $request) {
        $author = new Author();
    
        $form = $this->createForm(AuthorFormType::class, $author);
        $form->handleRequest($request);

        //Check if user and username already exists in author table
        if (($this->authorRepository->findOneByUsername($form["username"]->getData()))
                && ($this->authorRepository->findOneByUsername($form["name"]->getData())))
            {

            $this->addFlash('error', 'Unable to create user, username OR name already exists!');
            return $this->redirectToRoute('author_create');
        }

      
        if ($form->isSubmitted() && $form->isValid()) {
            $session = $request->getSession();
    
            // set session username
            $session->set('username', $form["username"]->getData());
          
            $this->entityManager->persist($author);
            $this->entityManager->flush($author);
    
            return $this->redirectToRoute('blog_list');
        }
    
        return $this->render('admin/create_author.html.twig', [
            'form' => $form->createView()
        ]);
    }


     /**
     * @Route("/admin/logout", name="author_logout")
     * @Method({"GET"})
     */
    public function logoutAuthor(Request $request) {
        $session = $request->getSession();

        // clear session username
        $session->remove('username');

        return $this->redirectToRoute('blog_list');
    }
}
