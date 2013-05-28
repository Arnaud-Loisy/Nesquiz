<?php

// Retourne la note d'un étudiant, pour une session, pour une question 
function noteQuestion($idEtu, $dateSession, $idQuestion) {
    global $dbcon;

    // récupérer le nb de réponses justes pour la question
    $res_nbRepJustes = pg_query($dbcon, requete_nb_rep_justes_question($idQuestion)) or die("Echec de la requête");
    $nbRepJustes = pg_fetch_array($res_nbRepJustes);

    // récupérer le nb de réponses fausses répondues par l'élève pour la question
    $res_nbRepFauxEtu = pg_query($dbcon, requete_nb_rep_fausses_d_un_etudiant_pour_question_d_une_session($idEtu, $idQuestion, $dateSession)) or die("Echec de la requête");
    $nbRepFauxEtu = pg_fetch_array($res_nbRepFauxEtu);

    // récupérer le nb de réponses totales répondues par l'élève pour la question

    $res_nbRepTotalEtu = pg_query($dbcon, requete_nb_rep_totales_d_un_etudiant_pour_question_d_une_session($idEtu, $idQuestion, $dateSession)) or die("Echec de la requête");
    $nbRepTotalEtu = pg_fetch_array($res_nbRepTotalEtu);

    // Calculer la note de l'étudiant pour la question
    if ($nbRepFauxEtu[0] != 0)
        $noteQuestion = 0;
    else
        $noteQuestion = $nbRepTotalEtu[0] / $nbRepJustes[0];

    return $noteQuestion;
}

// Retourne la note générale d'un étudiant, pour une session donnée
// cette note est exprimée en pourcent
function noteSession($idEtu, $dateSession) {
    global $dbcon;

    // récupérer id du quiz correspondant à la session
    //$res_idquiz = pg_query($dbcon, requete_idQuiz_correspondant_session($dateSession)) or die("Echec de la requête");
    //$tab_idquiz = pg_fetch_array($res_idquiz);
    //$idquiz = $tab_idquiz[0];

    // récupérer nb questions du quiz
    //$res_nbQuestions = pg_query($dbcon, requete_nb_questions_d_un_quiz($idquiz)) or die("Echec de la requête");
    //$nbQuestions = pg_fetch_array($res_nbQuestions);

    // récupérer la liste des questions du quiz
    //$res_listeQuestions = pg_query($dbcon, requete_liste_questions_d_un_quiz($idquiz)) or die("Echec de la requête");
	$res_listeQuestions=pg_query($dbcon,requete_questions_d_une_session($dateSession));
	$nbQuestions=pg_num_rows($res_listeQuestions);
    // Cumul des notes de chaque question
    $scoreTotal = 0;
    while ($listeQuestions = pg_fetch_array($res_listeQuestions)) {
        $scoreTotal+=noteQuestion($idEtu, $dateSession, $listeQuestions["idquestion"]);
    }

    // Calcul de la note moyenne du quiz de l'étudiant
    $noteQuiz = $scoreTotal / $nbQuestions;
	
	if ($nbQuestions == 0)
        return 0;
    else return round($noteQuiz * 100, 2);
    
}

// Retourne la moyenne générale d'un étudiant, pour toutes les sessions
// cette note est exprimée en pourcent
function moyenneGenerale($idEtu) {
    global $dbcon;
    $total = 0.0;
    $dateSession = pg_query($dbcon, requete_sessions_d_un_etudiant($idEtu));
	$nbSession=pg_num_rows($dateSession);
    while ($res = pg_fetch_array($dateSession)) {
        $total+=noteSession($idEtu, $res['datesession']);
    }
    
    

    //$array = pg_query($dbcon, requete_nombre_de_sessions_d_un_etudiant($idEtu));
    //$row = pg_fetch_array($array);
    //$nbSession = $row['count'];

    if ($nbSession == 0)
        return 0;
    else
        return round($total / $nbSession, 2);
}

function moyenneGeneralePromotion($numPromo) {
    global $dbcon;
    $total = 0.0;
    $totalSession = 0;
	$array = pg_query($dbcon, requete_nb_etudiant_d_une_promo($numPromo));
        $row = pg_fetch_array($array);
        $totalSession = $row['count'];
    $idEtu = pg_query($dbcon, requete_etudiant_d_une_promo($numPromo));
	
    while ($res = pg_fetch_array($idEtu)) {
        $total+=moyenneGenerale($res['idetudiant']);
        
    }


    if ($totalSession == 0)
        return 0;
    else return round($total / $totalSession, 2);
}

function moyenneMatiere($idEtu, $idMatiere) {
    global $dbcon;

    $total = 0.0;

    $dateSession = pg_query($dbcon, requete_sessions_d_un_etudiant_par_matiere($idEtu, $idMatiere));
	$nbSession=pg_num_rows($dateSession);
    while ($res = pg_fetch_array($dateSession)) {
        $total+=noteSession($idEtu, $res['datesession']);
    }

    //$array = pg_query($dbcon, requete_nombre_de_sessions_d_un_etudiant_matiere_donnee($idEtu, $idMatiere));
    //$row = pg_fetch_array($array);
    //$nbSession = $row['count'];
    
    if ($nbSession == 0)
        return 0;
    else return round($total / $nbSession, 2);
}

function moyennePromotionMatiere($promo,$idMatiere) {
    global $dbcon;

    $total = 0.0;
    $totalSession = 0;
	$nbEtu = pg_query($dbcon,requete_nb_etudiants_participants_par_matiere($promo,$idMatiere));
	$resNb = pg_fetch_array($nbEtu);
	$totalSession = $resNb['count'];
    $idEtu = pg_query($dbcon, requete_etudiants_participants_par_matiere($promo,$idMatiere));
    while ($res = pg_fetch_array($idEtu)) {
        $total+=moyenneMatiere(($res['idetudiant']),$idMatiere);
        $array = pg_query($dbcon, requete_nombre_de_sessions_d_un_etudiant($res['idetudiant']));
        
        
		
    }
	if ($totalSession == 0)
        return 0;
    else return round($total / $totalSession , 2);
}

// Retourne la note moyenne des étudiants de la session
// cette note est exprimée en pourcent
function moyenneSession($dateSession) {
    global $dbcon;

    // récupérer la liste des étudiants participant à la session     
    $res_listeEtudiants = pg_query($dbcon, requete_etudiants_participants($dateSession)) or die("Echec de la requête");

    $cumul = 0;
    $i = 0;
    while ($listeEtudiants = pg_fetch_array($res_listeEtudiants)) {
        $idEtu = $listeEtudiants["idetudiant"];
        $cumul+=noteSession($idEtu, $dateSession);
        $i++;
    }

    if ($i != 0)
        $moyenne = $cumul / $i;
    else
        $moyenne = 0;

    return round($moyenne, 2);
}

// Retourne la note moyenne des étudiants à une question d'une session
// cette note est exprimée en pourcent
function moyenneQuestion($dateSession, $idQuestion) {
    global $dbcon;

    // récupérer la liste des étudiants participant à la session      
    $res_listeEtudiants = pg_query($dbcon, requete_etudiants_participants($dateSession)) or die("Echec de la requête");

    $cumul = 0;
    $i = 0;
    while ($listeEtudiants = pg_fetch_array($res_listeEtudiants)) {
        $idEtu = $listeEtudiants["idetudiant"];
        $cumul+=noteQuestion($idEtu, $dateSession, $idQuestion);
        $i++;
    }

    if ($i != 0)
        $moyenne = $cumul / $i;
    else
        $moyenne = 0;

    return round($moyenne * 100, 2);
}

// Compare deux entrée du classement. Sert uniquement pour trier par note.
function cmpNotes($a, $b) {
    if ($a["note"] > $b["note"])
        return (-1);
    else {
        if ($a["note"] < $b["note"])
            return 1;
        else
            return 0;
    }
}

// Retourne le tableau représentant le classement des étudiants pour la session
function classementSession($dateSession) {
    global $dbcon;

    // récupérer la liste des étudiants participant à la session
    $res_listeEtudiants = pg_query($dbcon, requete_etudiants_participants($dateSession)) or die("Echec de la requête");

    // Stocker la moyenne de la session de chaque étudiant

    $classement = array();
    while ($listeEtudiants = pg_fetch_array($res_listeEtudiants)) {
        $idEtu = $listeEtudiants["idetudiant"];
        $prenomEtu = $listeEtudiants["prenometudiant"];
        $nomEtu = $listeEtudiants["nometudiant"];

        $classement[] = array("idetudiant" => $idEtu, "nom" => $nomEtu, "prenom" => $prenomEtu, "note" => noteSession($idEtu, $dateSession));
    }

    // Trier les élèves par note décroissante
    usort($classement, "cmpNotes");

    return ($classement);
}

// Retourne le rang de l'étudiant pour la session
function rangEtudiant($idEtu, $dateSession) {
    $classement = classementSession($dateSession);

    for ($i = 0; $i < count($classement); $i++) {
        if ($classement[$i]["idetudiant"] == $idEtu)
            return ($i + 1);
    }
}

function rangEtudiantMatiere($idEtu, $matiere) {
    
	global $dbcon;
    $classement = array();
    
    $respromo= pg_query($dbcon, requete_promo_d_un_etudiant($idEtu));
	$promo = pg_fetch_array($respromo);
	
    $idEtuu = pg_query($dbcon, requete_etudiants_participants_par_matiere($promo['promo'],$matiere));
    while ($listeEtudiants = pg_fetch_array($idEtuu)) {
        $idEtutemp = $listeEtudiants["idetudiant"];
        //$prenomEtu = $listeEtudiants["prenometudiant"];
        //$nomEtu = $listeEtudiants["nometudiant"];

        $classement[] = array("idetudiant" => $idEtutemp, "note" => moyenneMatiere($idEtutemp, $matiere));
    }

    // Trier les élèves par note décroissante
    usort($classement, "cmpNotes");
	//var_dump($classement);
    for ($i = 0; $i < count($classement); $i++) {
        if ($classement[$i]["idetudiant"] == $idEtu)
            return ($i + 1);
    }
}

function rangEtudiantGeneral($idEtu){
	global $dbcon;
    $classement = array();
    
    $respromo= pg_query($dbcon, requete_promo_d_un_etudiant($idEtu));
	$promo = pg_fetch_array($respromo);
	
    $idEtuu = pg_query($dbcon, requete_etudiant_d_une_promo($promo['promo']));
    while ($listeEtudiants = pg_fetch_array($idEtuu)) {
        $listeidEtu = $listeEtudiants["idetudiant"];
        //$prenomEtu = $listeEtudiants["prenometudiant"];
        //$nomEtu = $listeEtudiants["nometudiant"];

        $classement[] = array("idetudiant" => $listeidEtu, "note" => moyenneGenerale($listeidEtu));
        
    }
//var_dump($classement);
    // Trier les élèves par note décroissante
    usort($classement, "cmpNotes");
    //var_dump($classement);
    for ($i = 0; $i < count($classement); $i++) {
        if ($classement[$i]["idetudiant"] == $idEtu)
		//var_dump($classement);
            return ($i + 1);
    }
	
}
?>
