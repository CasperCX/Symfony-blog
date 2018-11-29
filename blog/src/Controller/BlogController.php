<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Entity\Author;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BlogController extends AbstractController
{
    /**
     * @Route("/", name="blog_list")
     * @Method({"GET"})
     */
    public function index() {
      $blogposts = $this->getDoctrine()->getRepository(BlogPost::class)->findAll();

      return $this->render('blog/index.html.twig', array('blogposts' => $blogposts));
    }

    /**
     * @Route("/blog/new", name="blog_new")
     * @Method({"GET", "POST"})
     */
    public function new(Request $request) {
        $blogpost = new BlogPost();

        $form = $this->createFormBuilder($blogpost)
        ->add('title', TextType::class, array('attr' => 
            array('class' => 'form-control')))
        ->add('body', TextareaType::class, array('required' => false, 'attr' =>
            array('class' => 'form-control')))
        ->add('save', SubmitType::class, array('label' => 'Create', 'attr' =>
            array('class' => 'btn btn-primary mt-3')))
        ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $blogpost = $form->getData(); 

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($blogpost);
            $entityManager->flush();
            return $this->redirectToRoute('blog_list');
        }

        return $this->render('blog/new.html.twig', array('form' => $form->createView() ));
    }

    /**
     * @Route("/blog/{id}", name="blog_show")
     * @Method({"GET"})
     */
    public function show($id) {
        $blog = $this->getDoctrine()->getRepository(BlogPost::class)->find($id);

        return $this->render('blog/show.html.twig', array('blog' => $blog));
    }

    
    /**
     * @Route("/blog/delete/{id}", name="blog_delete")
     * @Method({"DELETE"})
     */
    public function delete($id) {
        $blogpost = $this->getDoctrine()->getRepository(BlogPost::class)->find($id);
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($blogpost);
        $entityManager->flush();

        $response = new Response();
        $response->send();
    }


}



    // /**
    //  * @Route("/save", name="save")
    //  * @Method({"GET"})
    //  */
    // public function save() {
    //     $entityManager = $this->getDoctrine()->getManager();

    //     $blogpost = new BlogPost();
    //     $author = new Author();

    //     $author->setName('Casper Groenenberg');
    //     $author->setTitle('C Groenenberg');
    //     $author->setUsername('Casper');
    //     $author->setCompany("Github");
    //     $author->setShortBio('bio here');
    //     $author->setPhone('061234567');
    //     $author->setFacebook('');
    //     $author->setTwitter('');
    //     $author->setGithub('');


    //     $blogpost->setTitle('Blog number one3');
    //     $blogpost->setSlug("test3");
    //     $blogpost->setDescription("test3");
    //     $blogpost->setBody("test3");
    //     $blogpost->setAuthor($author);
    //     $blogpost->setCreatedAt(new \DateTime('Europe/Amsterdam'));
    //     $blogpost->setUpdatedAt(new \DateTime('Europe/Amsterdam'));

    //     $entityManager->persist($author);
    //     $entityManager->persist($blogpost);
    //     $entityManager->flush();

    //     return new Response('Saved an article');
        
    // }



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
