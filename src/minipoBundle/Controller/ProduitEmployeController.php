<?php

namespace minipoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use minipoBundle\Entity\Produit;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class ProduitEmployeController extends Controller
{
    public function afficheProduitEmployeAction(Request $request){
        //$repository=$this->getDoctrine()->getManager()->getRepository(Produit::class);
        //$listProduit = $repository->findallproducts();

        $em = $this->getDoctrine()->getManager();
        $listProduit = $em->getRepository('minipoBundle:Produit')->findAll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $listProduit,
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );

        $Valeurstocktotal=0;
        foreach($listProduit as $elt){
            $Valeurstocktotal=$Valeurstocktotal + ($elt->getPrix())*($elt->getQtestock());
        }

        $Qtetotal=0;
        foreach($listProduit as $plt){
            $Qtetotal=$Qtetotal + ($plt->getQtestock());
        }

        return $this->render('@minipo/Employe/Produit/index.html.twig', array(
            'produits'=>$listProduit,
            'ValeurStocktotal'=>$Valeurstocktotal,
            'Qtetotal'=>$Qtetotal,
            'produits'=>$pagination
        ));

    }

    public function ajoutProduitEmployeAction (Request $request){
        $msg='Ajouter un Produit';
        $Produit = new Produit();
        $form = $this->createForm('minipoBundle\Form\ProduitType', $Produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            /**
             * @var UploadedFile $file
             */
            $file = $Produit->getPhoto();
            $filename = md5(uniqid()).'.'.$file->guessExtension();

            $file->move(
                $this->getParameter('productimage_directory'),$filename
            );

            $Produit ->setPhoto($filename);

            $em = $this->getDoctrine()->getManager();
            $em->persist($Produit);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Product added successfully !');
            return $this->redirectToRoute('produit_index');
        }

        return $this->render('@minipo/Employe/Produit/ajout.html.twig', array(
            'form'=>$form->createView(),
            'msg'=>$msg
        ));
    }

    public function supprimerAction( $id){
        $em = $this->getDoctrine()->getManager();
        $produit = $em->find('minipoBundle:Produit', $id);

        $em->remove($produit);
        $em->flush();
        $this->get('session')->getFlashBag()->add('notice','Produit supprimé avec succée !');
        return $this->redirectToRoute('produit_index');
    }

    /*public function modifierAction(Request $request, $id){

        $em=$this->getDoctrine()->getManager();
        $Produit = $em->getRepository('minipoBundle:Produit')->find($id);

        $form = $this->createForm('minipoBundle\Form\ProduitType', $Produit);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->get('session')->getFlashBag()->add('notice','Produit modifié avec succée !');
            return $this->redirectToRoute('produit_index');
        }
        return $this->render('@minipo/Employe/Produit/ajout.html.twig', array(
            'form'=>$form->createView(),
        ));

    }*/

    public function statisticsAction(){
        $repository=$this->getDoctrine()->getManager()->getRepository(Produit::class);
        $findseloncategorie = $repository->findqteseloncategorie();
        $findselonfournisseur = $repository->findqteselonfournisseur();

        $em = $this->getDoctrine()->getManager();
        $listProduit = $em->getRepository('minipoBundle:Produit')->findAll();

        $totalorders = 0;
        foreach ($listProduit as $elt){
            $totalorders = $totalorders + 1;
        }

        return $this->render('@minipo/Employe/Produit/statistics.html.twig', array(
            'produitcateg'=>$findseloncategorie,
            'produitfournisseur'=>$findselonfournisseur,
            'totalorders'=>$totalorders
        ));
    }

    public function rechercheAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $motcle = $request->get('motcle');

        $repository = $em->getRepository('minipoBundle:Produit');
        $query = $repository->createQueryBuilder('p')
            ->where('p.designation like :designation')
            ->setParameter('designation', '%'.$motcle.'%')
            ->orderBy('p.designation', 'ASC')
            ->getQuery();

        $listProduit = $query->getResult();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $listProduit,
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );

        $Valeurstocktotal=0;
        foreach($listProduit as $elt){
            $Valeurstocktotal=$Valeurstocktotal + ($elt->getPrix())*($elt->getQtestock());
        }

        $Qtetotal=0;
        foreach($listProduit as $plt){
            $Qtetotal=$Qtetotal + ($plt->getQtestock());
        }

        return $this->render('@minipo/Employe/Produit/index.html.twig', array(
            'produits'=>$listProduit,
            'ValeurStocktotal'=>$Valeurstocktotal,
            'Qtetotal'=>$Qtetotal,
            'produits'=>$pagination
        ));

    }
}
