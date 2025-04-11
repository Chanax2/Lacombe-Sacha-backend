<?php  
function calculerMoyenne($nbr1,$nbr2, $nbr3) {
    $somme = $nbr1 + $nbr2 + $nbr3;
    $moyenne = $somme / 3;
    return $moyenne;
}

function afficherResultat($nom,$moyenne) {
    if ($moyenne >= 10) {
        echo "Bonjour $nom, vous avez réussi avec une moyenne de $moyenne.";
    } else {
        echo "Bonjour $nom, vous avez échoué avec une moyenne de $moyenne.";
    }
}

echo calculerMoyenne(10, 20, 30); 
echo "<br>";
echo afficherResultat("Jean", 15);
echo "<br>";
echo afficherResultat("Marie", 8);
echo "<br>";
echo afficherResultat("Paul", calculerMoyenne(5, 10, 15));
echo "<br>";
echo afficherResultat("Sophie", calculerMoyenne(4, 9, 12    ));
?>