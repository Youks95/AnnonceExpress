<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Modifier une annonce</title>
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
		}

		header {
			background-color: #fff;
			padding: 20px 40px;
			box-shadow: 0 2px 5px rgba(0,0,0,0.08);
		}

		header h1 {
			color: #ff6b4a;
			font-size: 28px;
		}

		.container {
			max-width: 500px;
			margin: 40px auto;
			padding: 0 20px;
		}

		.retour {
			display: inline-block;
			margin-bottom: 15px;
			color: #6b7280;
			text-decoration: none;
			font-size: 14px;
		}

		.retour:hover {
			color: #ff6b4a;
		}

		.formulaire {
			background-color: #fff;
			padding: 30px;
			border-radius: 10px;
			box-shadow: 0 2px 8px rgba(0,0,0,0.06);
			border: 1px solid #e5e7eb;
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
		.formulaire input[type="number"],
		.formulaire textarea {
			width: 100%;
			padding: 11px;
			margin-bottom: 14px;
			border: 1px solid #e5e7eb;
			border-radius: 6px;
			font-size: 14px;
			background-color: #fafafa;
		}

		.formulaire input:focus,
		.formulaire textarea:focus {
			outline: none;
			border-color: #ff6b4a;
			background-color: #fff;
		}

		.formulaire textarea {
			height: 90px;
			resize: vertical;
		}

		.formulaire input[type="file"] {
			margin-bottom: 18px;
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
	</style>
</head>
<body>

	<header>
		<h1>AnnonceExpress</h1>
	</header>

	<div class="container">

		<a class="retour" href="index.php">&larr; Retour aux annonces</a>

		<div class="formulaire">
			<h2>Modifier l'annonce</h2>

			<form method="post" enctype="multipart/form-data">

				<label>Titre</label>
				<input type="text" name="titre" placeholder="Titre" value="<?php echo isset($_GET['titre']) ? $_GET['titre'] : "" ; ?>">

				<label>Description</label>
				<textarea name="description" placeholder="Description"><?php echo isset($_GET['description']) ? $_GET['description'] : "" ; ?></textarea>

				<label>Prix en €</label>
				<input type="number" name="prix" placeholder="Prix en €" step="0.01" value="<?php echo isset($_GET['prix']) ? $_GET['prix'] : "" ; ?>">

				<label>Catégorie</label>
				<input type="text" name="categorie" placeholder="Catégorie" value="<?php echo isset($_GET['categorie']) ? $_GET['categorie'] : "" ; ?>">

				<label>Photo</label>
				<input type="file" name="photo">

				<input type="hidden" name="ancienne_photo" value="<?php echo isset($_GET['photo']) ? $_GET['photo'] : "" ; ?>">

				<input type="submit" name="modifier" value="Modifier l'annonce">

			</form>
		</div>

	</div>

	<?php

		$bdd = new mysqli("localhost","root","","annonce_express");

		function updateAnnonce($bdd, $id, $titre, $description, $prix, $categorie, $photo)
		{
			//requete
			$update = "update annonce set titre=?,description=?,prix=?,categorie=?,photo=? where idannonce=?";
			//preparer la requete
			$stmt = $bdd->prepare($update);
			$stmt->bind_param("ssdssi", $titre, $description, $prix, $categorie, $photo, $id);
			//executer la requete
			$stmt->execute();

			header("Location: index.php");
		}

		if (isset($_POST['modifier'])) {

			$ancienne_photo = $_POST['ancienne_photo'];

			if (!empty($_FILES['photo']['name'])) {
				$photoname = basename($_FILES['photo']['name']);
				$dossier = 'images/';

				if (!is_dir($dossier)) {
					mkdir($dossier);
				}

				$destination = $dossier . $photoname;
				move_uploaded_file($_FILES['photo']['tmp_name'], $destination);
			} else {
				$destination = $ancienne_photo;
			}

			$id = $_GET['id'];
			$titre = $_POST['titre'];
			$description = $_POST['description'];
			$prix = $_POST['prix'];
			$categorie = $_POST['categorie'];

			updateAnnonce($bdd, $id, $titre, $description, $prix, $categorie, $destination);
		}

	?>

</body>
</html>
