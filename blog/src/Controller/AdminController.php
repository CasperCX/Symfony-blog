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
        // if ($this->authorRepository->findOneByUsername($this->getUser()->getUserName())) {
        //     // Redirect to dashboard.
        //     $this->addFlash('error', 'Unable to create author, author already exists!');
    
        //     return $this->redirectToRoute('blog_list');
        // }
    
        $author = new Author();
    
        $form = $this->createForm(AuthorFormType::class, $author);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($author);
            $this->entityManager->flush($author);
    
            return $this->redirectToRoute('blog_list');
        }
    
        return $this->render('admin/create_author.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
