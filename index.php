<?php
session_start();
@$nom=$_POST["nom"];
@$prenom=$_POST["prenom"];
@$email=$_POST["email"];
@$pass=$_POST["pass"];
@$repass=$_POST["repass"];
@$valider=$_POST["valider"];
$erreur="";
if(isset($valider)){
   if(empty($nom)) $erreur="Nom laissé vide!";
   elseif(empty($prenom)) $erreur="Prénom laissé vide!";
   elseif(empty($prenom)) $erreur="Prénom laissé vide!";
   elseif(empty($email)) $erreur="email laissé vide!";
   elseif(empty($pass)) $erreur="Mot de passe laissé vide!";
   elseif($pass!=$repass) $erreur="Mots de passe non identiques!";
   else{
      include("connexion.php");
      $sel=$db->prepare("select id from clients where email=? limit 1");
      $sel->execute(array($email));
      $tab=$sel->fetchAll();
      if(count($tab)>0)
         $erreur="Cet email existe déjà!";
      else{
         $ins=$db->prepare("insert into clients(nom,prenom,email,mot_de_passe) values(?,?,?,?)");
         if($ins->execute(array($nom,$prenom,$email,md5($pass))))
            header("location:login.php");
      }   
   }
}

?>

<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8" />
      <style>
         *{
            font-family:arial;
         }
         body{
            margin:20px;
         }
         input{
            border:solid 1px #2222AA;
            margin-bottom:10px;
            padding:16px;
            outline:none;
            border-radius:6px;
         }
         .erreur{
            color:#CC0000;
            margin-bottom:10px;
         }
         a{
            font-size:12pt;
            color:#2222AA;
            text-decoration:none;
            font-weight:normal;
         }
         a:hover{
            text-decoration:underline;
         }
      </style>
   </head>
   <body>
      <h1>Inscription</h1>
      <div class="erreur"><?php echo $erreur ?></div>
      <form name="fo" method="post" action="">
         <input type="text" name="nom" placeholder="Nom" value="<?php echo $nom?>" /><br />
         <input type="text" name="prenom" placeholder="Prénom" value="<?php echo $prenom?>" /><br />
         <input type="email" name="email" placeholder="Login" value="<?php echo $email?>" /><br />
         <input type="password" name="pass" placeholder="Mot de passe" /><br />
         <input type="password" name="repass" placeholder="Confirmer Mot de passe" /><br />
         <input type="submit" name="valider" value="S'authentifier" /> <br>
         <span>Vous avez avez déjà compte ? <a href="./login.php" target="_blank">Se connecter</a></span>
      </form>
   </body>
</html>