<?php
session_start();
require_once("class.client.php");
$login = new CLIENT();

if($login->is_loggedin()!="")
{
	$login->redirect('accueil.php');
}

if(isset($_POST['btn-connexion']))
{
	$cmail = strip_tags($_POST['txt_email']);
	$cpass = strip_tags($_POST['txt_password']);
		
	if($login->doLogin($cmail,$cpass))
	{
		$login->redirect('accueil.php');
	}
	else
	{
		$error = "Informations Incorrectes !";
	}	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Connexion</title>
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
     
        
       <form class="form-signin" method="post" id="login-form">
      
        <h2 class="form-signin-heading">Se connecter au site</h2><hr />
        
        <div id="error">
        <?php
			if(isset($error))
			{
				?>
                <div class="alert alert-danger">
                   <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !
                </div>
                <?php
			}
		?>
        </div>
        
        <div class="form-group">
        <input type="text" class="form-control" name="txt_email" placeholder="Email" required />
        <span id="check-e"></span>
        </div>
        
        <div class="form-group">
        <input type="password" class="form-control" name="txt_password" placeholder="Mot de  passe" />
        </div>
       
     	<hr />
        
        <div class="form-group">
            <button type="submit" name="btn-connexion" class="btn btn-default">
                	<i class="glyphicon glyphicon-log-in"></i> &nbsp; SE CONNECTER
            </button>
        </div>  
      	<br />
        <label>Pas encore client ? <a href="inscription.php">Inscrivez-vous</a></label>
      </form>

    </div>
    
</div>

</body>
</html>