<?php
session_start();
require_once('class.client.php');
$client = new CLIENT();

if($client->is_loggedin()!="")
{
	$client->redirect('accueil.php');
}

if(isset($_POST['btn-inscription']))
{
	$cmail = strip_tags($_POST['txt_cmail']);
	$cpass = strip_tags($_POST['txt_cpass']);
        $cnom = strip_tags($_POST['txt_cnom']);
        $cprenom = strip_tags($_POST['txt_cprenom']);
        $ctel = strip_tags($_POST['txt_ctel']);
        $cadresse = strip_tags($_POST['txt_cadresse']);
	
	if($cmail=="")	{
		$error[] = "Entrez l'adresse email !";	
	}
	else if(!filter_var($cmail, FILTER_VALIDATE_EMAIL))	{
	    $error[] = 'Veuillez entrez une adresse email valide !';
	}
	else if($cpass=="")	{
		$error[] = "Entrez le mot de passe !";
	}             
	else if(strlen($cpass) < 6){
		$error[] = "Le mot de passe doit contenir au moins 6 caractères";	
	}
	else
	{
		try
		{
			$stmt = $client->runQuery("SELECT emailclient FROM client WHERE emailclient=:cmail");
			$stmt->execute(array(':cmail'=>$cmail));
			$rowclient=$stmt->fetch(PDO::FETCH_ASSOC);
				
			if($rowclient['emailclient']==$cmail) {
				$error[] = "Désolé adresse email non disponible !";
			}
			else
			{
				if($client->register($cnom,$cprenom,$cmail,$cpass,$ctel,$cadresse)){	
					$client->redirect('inscription.php?joint');
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Hotel : Inscription</title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="style.css" type="text/css"  />
</head>
<body>
    
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><span class="glyphicon glyphicon-home"></span>&nbsp;Accueil</a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Hotel</a></li>
        <li><a href="#">Chambre</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</nav>

<div class="signin-form">

<div class="container">
    	
        <form method="post" class="form-signin">
            <h2 class="form-signin-heading">Inscription</h2><hr />
            <?php
			if(isset($error))
			{
			 	foreach($error as $error)
			 	{
					 ?>
                     <div class="alert alert-danger">
                        <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
                     </div>
                     <?php
				}
			}
			else if(isset($_GET['joint']))
			{
				 ?>
                 <div class="alert alert-info">
                      <i class="glyphicon glyphicon-log-in"></i> &nbsp; Inscription réussie <a href='index.php'>connectez-vous</a> ici
                 </div>
                 <?php
			}
			?>
            <div class="form-group">
            <input type="text" class="form-control" name="txt_cmail" placeholder="Email" value="<?php if(isset($error)){echo $cmail;}?>" />
            </div>
            <div class="form-group">
            	<input type="password" class="form-control" name="txt_cpass" placeholder="Mot de passe" />
            </div>
            <div class="form-group">
            <input type="text" class="form-control" name="txt_cnom" placeholder="Nom" />
            </div>
            <div class="form-group">
            <input type="text" class="form-control" name="txt_cprenom" placeholder="Prénom" />
            </div>
            <div class="form-group">
            <input type="text" class="form-control" name="txt_ctel" placeholder="Téléphone" />
            </div>
            <div class="form-group">
            <input type="text" class="form-control" name="txt_cadresse" placeholder="Adresse" />
            </div>
            <div class="clearfix"></div><hr />
            <div class="form-group">
            	<button type="submit" class="btn btn-primary" name="btn-inscription">
                	<i class="glyphicon glyphicon-open-file"></i>&nbsp;INSCRIPTION
                </button>
            </div>
            <br />
            <label>Déjà inscrit(e) ? <a href="index.php">Connectez-vous</a></label>
        </form>
       </div>
</div>

</div>

</body>
</html>