<?php
// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifie si le champ "projet" est rempli dans le formulaire
    if(isset($_POST["projet"]) && !empty($_POST["projet"])) {
        // Récupère le prénom de la personne et le projet choisi
        $prenom = htmlspecialchars($_POST["prenom"]);
        $projet = htmlspecialchars($_POST["projet"]);

        // Stocke les votes dans un fichier texte
        $fichierVotes = "votes.txt";

        // Vérifie si le fichier existe déjà
        if (file_exists($fichierVotes)) {
            // Lit le contenu du fichier
            $contenu = file_get_contents($fichierVotes);

            // Découpe le contenu en lignes
            $lignes = explode("\n", $contenu);

            // Initialise un tableau associatif pour stocker les votes
            $votes = [];

            // Parcourt chaque ligne pour extraire les votes
            foreach ($lignes as $ligne) {
                $vote = explode(":", $ligne);
                $votes[$vote[0]] = (int)$vote[1];
            }

            // Incrémente le compteur du projet choisi
            if (isset($votes[$projet])) {
                $votes[$projet]++;
            } else {
                $votes[$projet] = 1;
            }
        } else {
            // Crée un nouveau fichier et initialise le vote pour le projet choisi
            $votes = [$projet => 1];
        }

        // Stocke les votes mis à jour dans le fichier
        $contenuVotes = "";
        foreach ($votes as $projet => $nombreVotes) {
            $contenuVotes .= "$projet:$nombreVotes\n";
        }
        file_put_contents($fichierVotes, $contenuVotes);

        // Calcule le total des votes pour tous les projets
        $totalVotes = array_sum($votes);

        // Calcule le pourcentage de personnes partageant l'avis pour le projet choisi
        $pourcentage = ($votes[$projet] / $totalVotes) * 100;

        // Retourne la phrase avec le prénom et le pourcentage
        echo "$prenom, vous partagez l'avis de $pourcentage% des personnes.";
    } else {
        // Affiche un message d'erreur si le champ "projet" n'est pas rempli
        echo "Le champ de projet est vide.";
    }
}
?>
