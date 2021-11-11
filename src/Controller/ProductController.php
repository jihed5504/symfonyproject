<?php

namespace App\Controller;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;


class ProductController extends AbstractController
{
    #[Route('/product', name: 'product')]
    public function index(): Response
    {   $repo=$this->getDoctrine()->getRepository(Product::class);
        $products=$repo->findAll();
        //$products=["article1","article2","article3"];
        return $this->render('product/index.html.twig', [
         'products' => $products ,
        ]);
    }

    /**
     * @Route("/product/add", name="add")
     */
    public function add(): Response
    {
        $manager=$this->getDoctrine()->getManager();
        $product=new Product();
        $product->setLib("lib test11111 ")
            ->setPrixUnitaire(500)
            ->setDecription(" TEST description de l'article n° 12222")
            ->setImage("http://placehold.it/350*150");
            $manager->persist($product);

        $manager-> flush();
        #return new Response("Ajout Valide ". $product->getId() );
        return $this->redirectToRoute('product');

    }


    /**
     * @Route("/product/detail/{id}", name="detail")
     */
    public function detail($id): Response
    {
        $repo=$this->getDoctrine()->getRepository(Product::class);
        $products=$repo->find($id);
        return $this->render('product/detail.html.twig', ['product' => $products]) ;
        }

    /**
     * @Route("/product/delete/{id}", name="delete")
     */
    public function delete($id): Response
    {
        $repo=$this->getDoctrine()->getRepository(Product::class);
        $products=$repo->find($id);
        $manager=$this->getDoctrine()->getManager();
        $manager->remove($products);
        $manager-> flush();
        #return $this->render('product/index.html.twig') ;
        #return new Response("supression Validée ");
        return $this->redirectToRoute('product');
        }
        /**
            * @Route("/product/add1", name="add1")
        */
        public function new(Request $request ): Response
        {
            $prod = new Product();
            // ...
    
            $form = $this->createForm(ProductType::class, $prod);
            $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($prod);
             $entityManager->flush();

            return $this->redirectToRoute('product');
        }
    
            return $this->renderForm('product/new.html.twig', [
                'formpro1' => $form,
            ]);
        }
        /**
            * @Route("/product/{id}/edit", name="edit")
        */
        public function edit(Product $prod,Request $request,$id): Response
    {
        $form = $this->createForm(ProductType::class, $prod);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $prod = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($prod); 
            $entityManager->flush();
            $repo=$this->getDoctrine()->getRepository(Product::class);
            $product=$repo->find($id);
            return $this->render('product/detail.html.twig', [
                'product' => $product,
            ]);
        }
        return $this->renderForm('product/new.html.twig', [
            'formpro1' => $form,
        ]);
    }


}
