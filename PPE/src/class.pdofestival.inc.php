<?php

class PdoFestival{   		
      	private static $serveur='mysql:host=localhost';
      	private static $bdd='dbname=ebt_gsb';   		
      	private static $user='sqlbtebbani' ;    		
      	private static $mdp='savary' ;	
		private static $monPdo;
		private static $monPdoFestival=null;
/**
 * Constructeur privé, crée l'instance de PDO qui sera sollicitée
 * pour toutes les méthodes de la classe
 */				
	private function __construct(){
            
    	 try{
            PdoFestival::$monPdo = new PDO(PdoFestival::$serveur.';'.PdoFestival::$bdd, PdoFestival::$user, PdoFestival::$mdp); 
            PdoFestival::$monPdo->query("SET CHARACTER SET utf8");
            PdoFestival::$monPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           }
        catch (PDOException $e)
        {
            die($e->getMessage());
        }
          
        }

	
	
/**
 * Fonction statique qui crée l'unique instance de la classe
 
 * Appel : $instancePdoFestival = PdoFestival::getPdoFestival();
 
 * @return l'unique objet de la classe PdoFestival
 */
	public  static function getPdoFestival(){
		if(PdoFestival::$monPdoFestival==null){
			PdoFestival::$monPdoFestival= new PdoFestival();
		}
		return PdoFestival::$monPdoFestival;  
	}
        
         public function getListeMedecin(){
            $req = "SELECT medecin.id as id, medecin.nom as nom, medecin.prenom as prenom, COUNT(rapport.id) as nbrapport FROM medecin LEFT JOIN rapport ON rapport.idMedecin = medecin.id GROUP BY medecin.id ORDER BY medecin.nom, medecin.prenom";
            $res = PdoFestival::$monPdo->query($req);
            $medecins = $res->fetchAll();
            return $medecins;
        }
        
        /*public function ajoutCompteRendu($id, $date, $bilan, $motif, $idVisiteur, $idMedecin){
            $req = "INSERT INTO rapport VALUES ('$id','$date','$bilan','$motif', '$idVisiteur', '$idMedecin');";
            PdoGsb::$monPdo->exec($req);
        }*/
        
         public function getListeRapport(){
            $req = "SELECT date, motif, bilan, visiteur.nom, visiteur.prenom, medecin.nom as nomMedecin, medecin.prenom as prenomMedecin FROM medecin, rapport, visiteur WHERE visiteur.id=rapport.idVisiteur and medecin.id=rapport.idMedecin";
            $res = PdoFestival::$monPdo->query($req);
            $rapport = $res->fetchAll();
            return $rapport;
        }
        
        public function getListeMedicaments(){
            $req = "SELECT id, nomCommercial FROM medicament ORDER BY nomCommercial";
            $res = PdoFestival::$monPdo->query($req);
            $medicaments = $res->fetchAll();
            return $medicaments;
        }
        
         public function getUnMedecin($id){
            $req = "SELECT * FROM medecin where id=$id ORDER BY nom";
            $res = PdoFestival::$monPdo->query($req);
            $unMedecin = $res->fetch();
            return $unMedecin;
        }
        
        public function getListeRapportMedecin($id){
            $req = "SELECT date, motif, bilan, idMedecin, medecin.nom as nomMedecin, medecin.prenom as prenomMedecin FROM medecin, rapport WHERE medecin.id=rapport.idMedecin AND idMedecin='$id'";
            $res = PdoFestival::$monPdo->query($req);
            $rapportMedecin = $res->fetchAll();
            return $rapportMedecin;
        }
        
        public function getNbListeRapportMedecin(){
            $req = "SELECT *, count(*) as nbRapport FROM rapport, medecin WHERE rapport.idMedecin=medecin.id GROUP BY medecin.id ORDER BY nbRapport DESC";
            $res = PdoFestival::$monPdo->query($req);
            $nbRapportMedecin = $res->fetchAll();
            return $nbRapportMedecin;
        }
        
        public function modifMedecin($data, $id){
            $req = "UPDATE medecin Set nom = :nom, prenom = :prenom, adresse = :adresse, tel = :tel ,specialitecomplementaire = :specialite, departement = :departement where id = $id;');";
            $res = PdoFestival::$monPdo->prepare($req);
            $res->bindParam(':nom', $data['nom'], PDO::PARAM_STR);
            $res->bindParam(':prenom', $data['prenom'], PDO::PARAM_STR);
            $res->bindParam(':adresse', $data['adresse'], PDO::PARAM_STR);
            $res->bindParam(':tel', $data['tel'], PDO::PARAM_STR);
            $res->bindParam(':specialite', $data['specialitecomplementaire'], PDO::PARAM_STR);
            $res->bindParam(':departement', $data['departement'], PDO::PARAM_STR);
            $res->execute();
        }
        
        public function ajoutCompteRendu($data){
            var_dump($data['Visiteur']);
            $req = "Insert into rapport VALUES ('', :date, :motif, :bilan, :idVisiteur, :idMedecin)";
            $res = PdoFestival::$monPdo->prepare($req);
            $res->bindParam(':date', $data['date']->format('Y-m-d'), PDO::PARAM_STR);
            $res->bindParam(':motif', $data['motif'], PDO::PARAM_STR);
            $res->bindParam(':bilan', $data['bilan'], PDO::PARAM_STR);
            $res->bindParam(':idVisiteur', $data['Visiteur'], PDO::PARAM_STR);
            $res->bindParam(':idMedecin', $data['Medecin'], PDO::PARAM_STR);
            $res->execute();
        }
        
        public function getIdRapport() {
            $req = "SELECT max(id) as id FROM rapport";
            $res = PdoFestival::$monPdo->query($req);
            $id = $res->fetch();
            return $id;
        }
        
         public function getIdMedoc($nom) {
            $req = "SELECT id FROM medicament where nomCommercial = '$nom' ";
            $res = PdoFestival::$monPdo->query($req);
            $id = $res->fetch(PDO::FETCH_ASSOC)["id"];
            return $id;
        }
        
        public function ajoutMedoc($num, $idMedoc, $quantite) {
            var_dump('est'.$idMedoc);
            $req = "insert into offrir values (:id, :medoc, :qte);"; 
            $res = PdoFestival::$monPdo->prepare($req);
            $res->bindParam(':id', $num, PDO::PARAM_INT);
            $res->bindParam(':medoc', $idMedoc, PDO::PARAM_STR);
            $res->bindParam(':qte', $quantite, PDO::PARAM_INT);
            $res->execute();
        }
    }
?>