<?php

use Symfony\Component\HttpFoundation\Request;
use PPE\Form\Type\GroupeType;
use PPE\Form\Type\MedecinType;

// Home page
$app->get('/accueil/', function () use ($app){

    return $app['twig']->render('v_accueil.html.twig'); 
    
})
->bind('homepage'); // nom attribué à la route

$app->get('/listeMedecin/', function () use ($app){
    require '../src/class.pdofestival.inc.php';
    $pdo = PdoFestival::getPdoFestival();
    $medecins = $pdo->getListeMedecin();

    return $app['twig']->render('v_listeMedecin.html.twig', array('medecins' => $medecins)); 
})
->bind('listeMedecin');

$app->match('/ajoutRapport/', function(Request $request) use ($app){
    require '../src/class.pdofestival.inc.php';
    $pdo = PdoFestival::getPdoFestival();
    if($request->getMethod()=='GET'){
        $form = $app['form.factory']->create(GroupeType::class);
        $formView = $form->createView();
        return $app['twig']->render('v_ajoutRapport.html.twig',array('form' => $formView));        
    }
    if($request->getMethod()=='POST'){
        $form = $app['form.factory']->create(GroupeType::class);
        $form -> handleRequest($request);
        
        if($form->isValid()){
            $data = $form->getData();
            $pdo->ajoutCompteRendu($data);
            var_dump($data);
            $tabNomMedoc = $_POST["nom"];
            $tabQuantites = $_POST["quantite"];
            $resultId = $pdo->getIdRapport();
            $num = $resultId['id'];
            if (!empty($tabNomMedoc)){
                $indice=0;
                foreach( $tabNomMedoc as $unNomMedoc){
                    $idMedoc = $pdo-> getIdMedoc($unNomMedoc);
                    var_dump($idMedoc);
                    $pdo->ajoutMedoc($num, $idMedoc, $tabQuantites[$indice]); 
                    $indice++;
                }
            }
//            var_dump($request->getMethod());
//            $noms = $_POST["nom"];
//            $quantites = $_POST["quantite"];
//            $resultId = $pdo->getIdRapport();
//            $num = $resultId['id'];
//            if ($noms){
//                for ($i=0; $i < count($noms); $i++ ){
//                    $nom = $noms[$i];
//                    $quantite = $quantites[$i];
//                    $idMedoc = $pdo-> getIdMedoc($nom);
//                    var_dump($idMedoc);
//                    $pdo->ajoutMedoc($num, $idMedoc, $quantite); 
//                }
//            }
           //  return $app->redirect($app['url_generator']->generate('validerRapport', array('id' => $num)));
           return $app['twig']->render('v_validerRapport.html.twig',array());    
        }  
    }
})
->bind('ajoutRapport');

$app->get('/validerRapport/{id}', function ($id) use ($app){
    require '../src/class.pdofestival.inc.php';

    return $app['twig']->render('v_validerRapport.html.twig'); 

})
->bind('validerRapport');

$app->get('/listeRapport/', function () use ($app){
    require '../src/class.pdofestival.inc.php';
    $pdo = PdoFestival::getPdoFestival();
    $rapport = $pdo->getListeRapport();

    return $app['twig']->render('v_listeRapport.html.twig', array('rapport' => $rapport)); 
})
->bind('listeRapport');

$app->get('/listeMedicaments/', function () use ($app){
    require '../src/class.pdofestival.inc.php';
    $pdo = PdoFestival::getPdoFestival();
    $medicaments = $pdo->getListeMedicaments();

    return $app['twig']->render('v_listeMedicaments.html.twig', array('medicaments' => $medicaments)); 
})
->bind('listeMedicaments');

$app->get('/unMedecin/{id}', function ($id) use ($app){
    require '../src/class.pdofestival.inc.php';
    $pdo = PdoFestival::getPdoFestival();
    $medecin = $pdo->getUnMedecin($id);

    return $app['twig']->render('v_unMedecin.html.twig', array('medecin' => $medecin)); 
})
->bind('unMedecin');

$app->get('/listeRapportMedecin/{id}', function ($id) use ($app){
    require '../src/class.pdofestival.inc.php';
    $pdo = PdoFestival::getPdoFestival();
    $rapportMedecin = $pdo->getListeRapportMedecin($id);

    return $app['twig']->render('v_listeRapportMedecin.html.twig', array('rapportMedecin' => $rapportMedecin)); 
})
->bind('listeRapportMedecin');

$app->match('/modifierMedecin/{id}', function(Request $request, $id) use ($app){
    require '../src/class.pdofestival.inc.php';
    $pdo = PdoFestival::getPdoFestival();
    $form=$app['form.factory']->create(MedecinType::class);
    if($request->getMethod()=='GET'){
        $formView = $form->createView();
        $medecin = $pdo->getUnMedecin($id);
        return $app['twig']->render('v_modifierMedecin.html.twig',array('form' => $formView, 'medecin' => $medecin));        
    }
    if($request->getMethod()=='POST'){
        $form -> handleRequest($request);
        
        if($form->isValid()){
            $data = $form->getData();
            var_dump($data);
            $pdo->modifMedecin($data, $id);
            return $app->redirect($app['url_generator']->generate('uneModif', array('id' => $id)));
        }    
    }  
})
->bind('modifierMedecin');

$app->get('/listeMedecin/', function () use ($app){
    require '../src/class.pdofestival.inc.php';
    $pdo = PdoFestival::getPdoFestival();
    $medecins = $pdo->getListeMedecin();

    return $app['twig']->render('v_listeMedecin.html.twig', array('medecins' => $medecins)); 

})
->bind('uneModif');
