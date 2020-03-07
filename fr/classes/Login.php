<?php

 if(isset($_SESSION['lang'])){
      $lage='langues/'.$_SESSION['lang'].'.php';
      
      require_once ($lage);
      }
      else{
        $_SESSION['lang']='Fr';
         $lage='langues/'.$_SESSION['lang'].'.php'; 
      
      require_once ($lage);
      }
   


/**
 * Class login
 * handles the user's login and logout process
 */
class Login
{

   // global $lang;
    /**
     * @var object The database connection
     */
    private $db_connection = null;
    /**
     * @var array Collection of error messages
     */
    public $errors = array();
    /**
     * @var array Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$login = new Login();"
     */
    public function __construct()
    {
        // create/read session, absolutely necessary
        session_start();

        // check the possible login actions:
        // if user tried to log out (happen when user clicks logout button)
        if (isset($_GET["logout"])) {
            $this->doLogout();
        }
        // login via post data (if user just submitted a login form)
        elseif (isset($_POST["email"])) {
            $this->dologinWithPostData();
        }


    }

    

    /**
     * log in with post data
     */
    private function dologinWithPostData()
    {
        // check login form contents
        if (empty($_POST['email'])) {
            $this->errors[] = $lang['addresseEmailVide'];
        } elseif (empty($_POST['password'])) {
            $this->errors[] = $lang['Mot de passe vide.'];
        } elseif (!empty($_POST['email']) && !empty($_POST['password'])) {

            // create a database connection, using the constants from config/db.php (which we loaded in index.php)
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

                // escape the POST stuff
                $email = $this->db_connection->real_escape_string($_POST['email']);

                // database query, getting all the info of the selected user (allows login via email address in the
                // username field)
                $sql = "SELECT *
                        FROM users
                        INNER JOIN personne ON users.personne_idpersonne = personne.idpersonne
                        AND personne.lisible = 1
                        AND users.lisible = 1                        
                        AND login = '$email'";

                       // var_dump($sql);
                $result_of_login_check = $this->db_connection->query($sql);

                // if this user exists
                if ($result_of_login_check->num_rows == 1) {

                    // get result row (as an object)
                    $result_row = $result_of_login_check->fetch_object();

                    // using PHP 5.5's password_verify() function to check if the provided password fits
                    // the hash of that user's password
                    if (password_verify($_POST['password'], $result_row->password)) {                        
                       
                            // write user data into PHP SESSION (a file on your server)
                            $_SESSION['idusers'] = $result_row->idusers;
                            $_SESSION['idpersonne'] = $result_row->idpersonne;
                            $_SESSION['role'] = $result_row->role;
                            $_SESSION['login'] = $result_row->login;
                            $_SESSION['nom'] = $result_row->nom;
                            $_SESSION['prenom'] = $result_row->prenom;
                            $_SESSION['user_login_status'] = $result_row->etat;
                            $_SESSION['code'] = $result_row->code;
                            $_SESSION['etat'] = $result_row->etat;
                            //$_SESSION['ideper'] = $result_row->etat;
                             

                    } else {
                        $this->errors[] = $lang['nonCorrespondance'];
                    }
                } else {
                    $this->errors[] = $lang['nonCorrespondance'];
                }
            } else {
                $this->errors[] = $lang['ProblemeDeConnexion'];
            }
        }
    }



    /**
     * perform the logout
     */
    public function doLogout()
    {

  
       // $this->update('connexion', array('etat'=>0), 'id_user', '=', $_SESSION['id_connexion']);
        // delete the session of the user
        
        $_SESSION = array(); 
        session_destroy();  

        // return a little feeedback message
        $this->messages[] =  'Vous avez déconnecté';

    }

    /**
     * simply return the current state of the user's login
     * @return boolean user's login status
     */
    public function isUserLoggedIn()
    {
        
        if (isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1) {
            
             $retour = $this->insert('connexion', array('idusers'=>$_SESSION['idusers'], 'role'=>$_SESSION['role'],
                                'date_connexion'=>date('Y-m-d'), 'heure_connexion'=>date('H:i:s'), 'etat'=>1));
             if($retour)               
                $_SESSION['id_connexion'] = $this->get_last_insert_id('connexion');
                return 1;

        }elseif(isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 0){

            $retour = 0;
        }else{

            return -1;
        }

    }
    
    public function insert($table, $data){
        global $con;
        $champ = array();
        $valeur = array();

        foreach($data as $key => $line){
            $champ[] = $key;
            $valeur[] = "'$line'";
        }

        $colonne = implode($champ, ',');
        $donnees = implode($valeur, ',');

        $req = "INSERT INTO $table($colonne) VALUES($donnees)";
        //var_dump($req);
        return mysqli_query($con, $req);
     }
     
     public function update($table, $data, $where, $operateur, $valeur){
        global $con;
        $champ = array();

        foreach($data as $key => $line){
            $champ[] = $key."='".$line."'";
        }
        $donnees = implode($champ, ',');

        $req = "UPDATE  $table SET $donnees WHERE $where $operateur '$valeur' ";
       // var_dump($req);
        //return mysqli_query($con, $req);
     }
     
      public function get_last_insert_id($table){
	global $con;
	$query=mysqli_query($con,"select last_insert_id() as id from $table");
	$rw=mysqli_fetch_array($query);
	$value=$rw['id'];
	return $value;
     }
  
    
}
