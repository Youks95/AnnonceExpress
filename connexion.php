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

	function connexionUser($bdd, $pseudo, $mdp)
	{
		//requete
		$select = "select * from user where pseudo=? and mdp=?";
		//preparer la requete
		$stmt = $bdd->prepare($select);
		$stmt->bind_param("ss", $pseudo, $mdp);
		//executer la requete
		$stmt->execute();
		$result = $stmt->get_result();

		return $result->fetch_assoc();
	}

// ========== ACTION ==========

	if (isset($_POST['connexion'])) {
		$pseudo = $_POST['pseudo'];
		$mdp = $_POST['mdp'];

		$user = connexionUser($bdd, $pseudo, $mdp);

		if ($user) {
			$_SESSION['iduser'] = $user['iduser'];
			$_SESSION['pseudo'] = $user['pseudo'];
			$_SESSION['role'] = $user['role'];
			header("Location: index.php");
			exit();
		} else {
			$erreur = "Pseudo ou mot de passe incorrect.";
		}
	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>AnnonceExpress - Connexion</title>

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
	</style>
</head>
<body>

	<!-- ========== HTML ========== -->
	<h1>AnnonceExpress</h1>

	<div class="formulaire">
		<h2>Connexion</h2>

		<?php if (isset($erreur)) { echo '<div class="erreur">' . $erreur . '</div>'; } ?>

		<form method="post">
			<label>Pseudo</label>
			<input type="text" name="pseudo" placeholder="Votre pseudo">

			<label>Mot de passe</label>
			<input type="password" name="mdp" placeholder="Votre mot de passe">

			<input type="submit" name="connexion" value="Se connecter">
		</form>
	</div>

</body>
</html>
