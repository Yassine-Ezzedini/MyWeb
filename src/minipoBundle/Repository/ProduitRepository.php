<?php


namespace minipoBundle\Repository;


use Doctrine\ORM\EntityRepository;

class ProduitRepository extends EntityRepository
{

    public function myFindProduitByPanier($idPan,$idProd){
        $qb=$this->getEntityManager()->
        createQuery("select p 
                     from  minipoBundle:Produit p , minipoBundle:Lignecommande lc 
                     where p.idprod=lc.idprod
                     and lc.idcmd=$idPan
                     and lc.idprod=$idProd 
                     ");

        return $query=$qb->getOneOrNullResult();
    }

    public function myFindProduitByPanier1($idPan,$idProd){
        $qb=$this->getEntityManager()->
        createQuery("select p 
                     from  minipoBundle:Produit p , minipoBundle:Lignecommande lc 
                     where p.idprod=lc.idprod
                     and lc.idcmd=$idPan
                     and lc.idprod=$idProd 
                     ");

        return $query=$qb->getSingleResult();
    }

    //Find if fournisseur existe dans produit

    public function fournisseurdansproduit($id){
        $qb = $this->getEntityManager()->
            createQuery("select  p 
                        from minipoBundle:Produit p
                        where p.idf = $id
                        
                            ");
        return $query=$qb->getResult();
    }

    public function findqteseloncategorie(){
        $qb = $this->getEntityManager()->
        createQuery(" Select sum(p.qtestock) as qte , c.nom 
        from minipoBundle:Produit p , minipoBundle:Categorie c 
        where p.idcateg=c.idcateg 
        group by c.nom 
        order by qte asc ");
        return $query=$qb->getResult();
    }

    public function findqteselonfournisseur(){
        $qb = $this->getEntityManager()->
        createQuery(" Select sum(p.qtestock) as qte , c.nom
        from minipoBundle:Produit p , minipoBundle:Fournisseur c 
        where p.idf=c.idf 
        group by c.nom 
        order by qte asc ");
        return $query=$qb->getResult();
    }


}