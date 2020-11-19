<?php
include_once("core.php");//notamment pour connecterBDD et deconnecterBDD.


$pdo = connecterBDD();
// On prépare la requête
$req = "SELECT * FROM Formation f JOIN Statut s ON f.idStatut_fk = s.idStatut JOIN Lieu l ON l.idLieu = f.idLieu_fk JOIN Adresse a ON a.idAdresse = l.idAdresse_fk where (accepte = 1) and (dates > (SELECT NOW()))";
//Affichage de toutes les données d'une formation
$stmt = $pdo->query($req);

while ($row = $stmt->fetch()) {

    $date = str_replace("00:00:00", " " , $row['dates']);
    $adresse = $row['numero']." ".$row['rue']." ".$row['postal']." ".$row['ville'];
    $tableau[] = array(
                "idLieu" => $row['idAdresse_fk'],
                "latitude" => $row['latitude'],
                "longitude" => $row['longitude'],
                "diplome" => $row['diplome'],
                "adresse" => $adresse,
                "nom" => $row['nom'],
                "dates" => $date,
                "duree" => $row['duree'],
                "prix" => $row['prix'],
              );
}

// On transforme le tableau PHP en json
$retour = json_encode($tableau);

// On retourne le tableau à la fonction appelante
echo $retour;
?>
