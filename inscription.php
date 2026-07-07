<?php

// ========== SESSION ==========

	session_start();

	if (isset($_SESSION['iduser'])) {
		header("Location: index.php");
		exit();
	}

// ========== CONNEXION BDD ==========

	$bdd = new mysqli("localhost","root","","annonce_express");

// ========== FONCTION ==========

	function insertUser($bdd, $pseudo, $mdp)
	{
		//requete
		$insert = "insert into user values(null,?,?,'user')";
		//preparer la requete
		$stmt = $bdd->prepare($insert);
		$stmt->bind_param("ss", $pseudo, $mdp);
		//executer la requete
		$stmt->execute();

		header("Location: connexion.php");
		exit();
	}

	function pseudoExiste($bdd, $pseudo)
	{
		//requete
		$select = "select * from user where pseudo=?";
		//preparer la requete
		$stmt = $bdd->prepare($select);
		$stmt->bind_param("s", $pseudo);
		//executer la requete
		$stmt->execute();
		$result = $stmt->get_result();

		return $result->num_rows > 0;
	}

// ========== ACTION ==========

	if (isset($_POST['inscrire'])) {
		$pseudo = $_POST['pseudo'];
		$mdp = $_POST['mdp'];
		$mdp_confirm = $_POST['mdp_confirm'];

		if (empty($pseudo) || empty($mdp)) {
			$erreur = "Tous les champs sont obligatoires.";
		} else if ($mdp != $mdp_confirm) {
			$erreur = "Les mots de passe ne correspondent pas.";
		} else if (pseudoExiste($bdd, $pseudo)) {
			$erreur = "Ce pseudo est déjà pris.";
		} else {
			insertUser($bdd, $pseudo, $mdp);
		}
	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>AnnonceExpress - Inscription</title>

	<!-- ========== CSS ========== -->
	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
			font-family: 'Segoe UI', Arial, sans-serif;
		}

		body {
			background-color: #f7f8fa;
			color: #1f2937;
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
			height: 100vh;
		}

		h1 {
			color: #ff6b4a;
			font-size: 32px;
			margin-bottom: 30px;
		}

		.formulaire {
			background-color: #fff;
			padding: 35px;
			border-radius: 10px;
			box-shadow: 0 2px 8px rgba(0,0,0,0.06);
			border: 1px solid #e5e7eb;
			width: 380px;
		}

		.formulaire h2 {
			margin-bottom: 20px;
			color: #1f2937;
			font-size: 20px;
		}

		.formulaire label {
			display: block;
			margin-bottom: 6px;
			font-size: 13px;
			color: #6b7280;
		}

		.formulaire input[type="text"],
		.formulaire input[type="password"] {
			width: 100%;
			padding: 11px;
			margin-bottom: 14px;
			border: 1px solid #e5e7eb;
			border-radius: 6px;
			font-size: 14px;
			background-color: #fafafa;
		}

		.formulaire input:focus {
			outline: none;
			border-color: #ff6b4a;
			background-color: #fff;
		}

		.formulaire input[type="submit"] {
			background-color: #ff6b4a;
			color: #fff;
			border: none;
			padding: 11px 28px;
			border-radius: 6px;
			cursor: pointer;
			font-size: 15px;
			font-weight: bold;
			width: 100%;
			margin-bottom: 12px;
		}

		.formulaire input[type="submit"]:hover {
			background-color: #e8552f;
		}

		.erreur {
			background-color: #fee2e2;
			color: #dc2626;
			padding: 10px;
			border-radius: 6px;
			font-size: 13px;
			margin-bottom: 14px;
		}

		.lien-connexion {
			text-align: center;
			font-size: 13px;
			color: #6b7280;
		}

		.lien-connexion a {
			color: #ff6b4a;
			text-decoration: none;
		}

		.lien-connexion a:hover {
			text-decoration: underline;
		}
	</style>
</head>
<body>

	<!-- ========== HTML ========== -->
	<h1>AnnonceExpress</h1>

	<div class="formulaire">
		<h2>Créer un compte</h2>

		<?php if (isset($erreur)) { echo '<div class="erreur">' . $erreur . '</div>'; } ?>

		<form method="post">
			<label>Pseudo</label>
			<input type="text" name="pseudo" placeholder="Votre pseudo">

			<label>Mot de passe</label>
			<input type="password" name="mdp" placeholder="Votre mot de passe">

			<label>Confirmer le mot de passe</label>
			<input type="password" name="mdp_confirm" placeholder="Confirmer le mot de passe">

			<input type="submit" name="inscrire" value="Créer mon compte">
		</form>

		<div class="lien-connexion">
			Déjà un compte ? <a href="connexion.php">Se connecter</a>
		</div>
	</div>

</body>
</html>
