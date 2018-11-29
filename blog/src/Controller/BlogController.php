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
     * @Route("/blog", name="homepage")
     */
    public function indexAction()
    {
        try {
            $entityManager = $this->getEntityManager();
            $entityManager->remove($entity);
            $entityManager->flush(); // save to the database
        } catch (\Doctrine\ORM\EntityNotFoundException $ex) {
            echo "Exception Found - " . $ex->getMessage() . "<br/>";
        }
        
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    /**
     * @Route("/save", name="save")
     * @Method({"GET"})
     */
    public function save() {
        $entityManager = $this->getDoctrine()->getManager();

        $blogpost = new BlogPost();
        $author = new Author();

        $author->setName('Casper Groenenberg');
        $author->setTitle('C Groenenberg');
        $author->setUsername('Casper');
        $author->setCompany("Github");
        $author->setShortBio('bio here');
        $author->setPhone('061234567');
        $author->setFacebook('');
        $author->setTwitter('');
        $author->setGithub('');


        $blogpost->setTitle('Blog number one3');
        $blogpost->setSlug("test3");
        $blogpost->setDescription("test3");
        $blogpost->setBody("test3");
        $blogpost->setAuthor($author);
        $blogpost->setCreatedAt(new \DateTime('Europe/Amsterdam'));
        $blogpost->setUpdatedAt(new \DateTime('Europe/Amsterdam'));

        $entityManager->persist($author);
        $entityManager->persist($blogpost);
        $entityManager->flush();

        return new Response('Saved an article');
        
    }

}
