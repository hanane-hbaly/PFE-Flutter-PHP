<?php

//  include "../../connect.php";

//  $id=filterRequest("ProduitID");
//  deleteData("produit","ProduitID='$id'");
//
//    <?php 

include "../../connect.php" ;

$id = filterRequest("ProduitID") ; 

$Imagep = filterRequest("Imagep") ; 

//deleteFile( "../../upload/produits", $Imagep) ; 
deleteFile("../../upload/produits"  , $Imagep) ; 

deleteData("produit" , "ProduitID = $id ") ; 
?>