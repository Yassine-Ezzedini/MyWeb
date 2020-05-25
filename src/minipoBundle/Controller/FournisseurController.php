<?php

namespace minipoBundle\Controller;

use minipoBundle\Entity\Fournisseur;
use minipoBundle\Entity\Produit;
use minipoBundle\Form\FournisseurType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FournisseurController extends Controller
{
    public function afficheAction(Request $request){
        $title = "Fournisseur";
        //$repository=$this->getDoctrine()->getManager()->getRepository(User::class);
        //$listFournisseur = $repository->findFournisseur();

        $em = $this->getDoctrine()->getManager();
        $listFournisseur = $em->getRepository('minipoBundle:Fournisseur')->findAll();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $listFournisseur,
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );

        return $this->render('@minipo/Employe/Fournisseur/index.html.twig', array(
            'fournisseurs'=>$listFournisseur,
            'fournisseurs'=>$pagination,
            'msg'=>$title

        ));
        /*
          $em = $this->getDoctrine()->getManager();
          $fournisseurs = $em->getRepository(User::class)->findBy( array('genre'=>'fournisseur'));

        return $this->render('@minipo/Employe/Fournisseur/index.html.twig', array(
            'fournisseurs'=>$fournisseurs
        ));*/
    }

    public function ajoutAction(Request $request){
        $msg='Ajouter un Fournisseur';
        $title = "Fournisseur";

        $Fournisseur = new Fournisseur();
        $form=$this->createForm(FournisseurType::class, $Fournisseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();
            $em->persist($Fournisseur);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice','Fournisseur ajouté avec succée !');
            return $this->redirectToRoute('fournisseur_index');
        }
        return $this->render('@minipo/Employe/Fournisseur/ajout.html.twig', array(
            'form'=>$form->createView(),
            'msg'=>$msg,
            'title'=>$title
        ));
    }

    public function modifierAction(Request $request, $id){
        $msg = "Modifier un Fournisseur";
        $title = "Fournisseur";

        $em=$this->getDoctrine()->getManager();

        $Fournisseur = $em->getRepository('minipoBundle:Fournisseur')->find($id);
        $form = $this->createForm('minipoBundle\Form\FournisseurType', $Fournisseur);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->get('session')->getFlashBag()->add('notice','Fournisseur modifié avec succée !');
            return $this->redirectToRoute('fournisseur_index');
        }

        return $this->render('@minipo/Employe/Fournisseur/ajout.html.twig', array(
            'form'=>$form->createView(),
            'msg'=>$msg,
            'title'=>$title
        ));

    }


        public function supprimerAction($id){
            $em = $this->getDoctrine()->getManager();

            $repository=$this->getDoctrine()->getManager()->getRepository(Produit::class);

            $list = $repository->fournisseurdansproduit($id);

            if (empty($list)){
                $Fournisseur = $em->find('minipoBundle:Fournisseur', $id);

                $em->remove($Fournisseur);
                $em->flush();
                $this->get('session')->getFlashBag()->add('notice','Fournisseur supprimé avec succée !');
                return $this->redirectToRoute('fournisseur_index');
            }



            $this->get('session')->getFlashBag()->add('warning','Ce fournisseur ne peut pas etre supprimer car il est attaché à un produit existant');
            return $this->redirectToRoute('fournisseur_index');

        }


}
