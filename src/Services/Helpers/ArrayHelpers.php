<?php
namespace App\Services\Helpers;

class ArrayHelpers
{
    public function arrayunique(array $array) : array {
        // Utilisez array_filter avec une fonction personnalisée pour supprimer les doublons complets
        $donneesFiltrees = array_filter($array, function($element, $index) use ($array) {
            // Utilisez array_slice pour obtenir les éléments restants à partir de $index + 1
            $elementsRestants = array_slice($array, $index + 1);
            
            // Vérifiez si l'élément actuel existe dans les éléments restants
            $estDoublon = in_array($element, $elementsRestants, true);
            
            // Si ce n'est pas un doublon, retournez vrai pour le conserver
            return !$estDoublon;
        }, ARRAY_FILTER_USE_BOTH);

        // Remettez les résultats dans un tableau indexé
        $resultats = array_values($donneesFiltrees);

        // $resultats contiendra le tableau sans doublons complets
        return $resultats;
    }
    
}