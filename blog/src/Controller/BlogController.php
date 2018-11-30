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

use App\Form\BlogFormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BlogController extends AbstractController
{

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
     * @Route("/", name="blog_list")
     * @Method({"GET"})
     */
    public function index() {
      $blogposts = $this->blogPostRepository->findAll();

      return $this->render('blog/index.html.twig', array('blogposts' => $blogposts));
    }


    /**
     * @Route("/blog/new", name="blog_new")
     * @Method({"GET", "POST"})
     */
    public function new(Request $request) {
        $session = $request->getSession();
    
        //Check if a user is in session
        // get session username
        $username = $session->get('username');
        
        if ($username != "") {
            $blogpost = new BlogPost();

            $author = $this->authorRepository->findOneBy(array('username' => $username));
            $blogpost->setAuthor($author);

            //Set the time of creation
            $blogpost->setCreatedAt(new \DateTime('Europe/Amsterdam'));
            $blogpost->setUpdatedAt(new \DateTime('Europe/Amsterdam'));

            $form = $this->createForm(BlogFormType::class, $blogpost);
            $form->handleRequest($request);
            
        
            if ($form->isSubmitted() && $form->isValid()) {
                $this->entityManager->persist($blogpost);
                $this->entityManager->flush($blogpost);
        
                return $this->redirectToRoute('blog_list');
            }
        
            return $this->render('blog/new.html.twig', [
                'form' => $form->createView()
            ]);

        } else {
            $this->addFlash('error', 'You have to create an account in order to create a new blogpost!');
            return $this->redirectToRoute('author_create');
        }
    }


    /**
     * @Route("/blog/{id}", name="blog_show")
     * @Method({"GET"})
     */
    public function show($id) {
        $blog = $this->blogPostRepository->find($id);

        return $this->render('blog/show.html.twig', array('blog' => $blog));
    }

    
    /**
     * @Route("/blog/delete/{id}", name="blog_delete")
     * @Method({"DELETE"})
     */
    public function delete($id) {
        $blog = $this->blogPostRepository->find($id);
        
        $this->entityManager->remove($blog);
        $this->entityManager->flush($blog);

        return $this->redirectToRoute('blog_list');
    }

}








//Code snippet
  // try {
        //     $entityManager = $this->getEntityManager();
        //     $entityManager->remove($entity);
        //     $entityManager->flush(); // save to the database
        // } catch (\Doctrine\ORM\EntityNotFoundException $ex) {
        //     echo "Exception Found - " . $ex->getMessage() . "<br/>";
        // }
        
        // return $this->render('blog/index.html.twig', [
        //     'controller_name' => 'BlogController',
        // ]);
