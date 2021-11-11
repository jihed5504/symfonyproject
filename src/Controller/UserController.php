<?php

namespace App\Controller;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="userlist")
     */

    public function index(): Response
    {
        $repo=$this->getDoctrine()->getRepository(User::class);
        $users=$repo->findAll();
        return $this->render('user/index.html.twig', ['User' => $users]);
    }

    #[Route('/register', name: 'register')]
    public function registerpage(): Response
    {
        return $this->render('user/register.html.twig');
    }

    #[Route('/test', name: 'test')]
    public function testpage(): Response
    {
        return $this->render('user/test.html.twig');
    }



    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): response
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
         #return $this->render('home/index.html.twig');


    }
    /**
     * @Route("/user/delete/{id}", name="deleteuser")
     */
    public function deleteuser($id): Response
    {
        $repo=$this->getDoctrine()->getRepository(User::class);
        $users=$repo->find($id);
        $manager=$this->getDoctrine()->getManager();
        $manager->remove($users);
        $manager-> flush();
        #return $this->render('user/index.html.twig') ;
        #return new Response("supression Validée ");
        return $this->redirectToRoute('userlist');
        }
       
        /**
            * @Route("/user/add2", name="add2")
        */
        public function new(Request $request): Response
        {
            $user = new User();
            // ...
    
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
             $entityManager = $this->getDoctrine()->getManager();

             

             $entityManager->persist($user);
             $entityManager->flush();

            return $this->redirectToRoute('userlist');
        }
    
            return $this->renderForm('user/new.html.twig', [
                'formpro' => $form,
            ]);
        }
        #[Route('/{id}/edit', name: 'user_edit', methods: ['GET','POST'])]
        public function edit(Request $request, User $user, $id): Response
        {
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
    
               
                
                $entityManager->persist($user);
                $entityManager->flush();
    
                return $this->redirectToRoute('userlist', [], Response::HTTP_SEE_OTHER);
            }
    
            return $this->renderForm('user/new.html.twig', [
                'user' => $user,
                'formpro' => $form,
            ]);
        }
    
        
    


}