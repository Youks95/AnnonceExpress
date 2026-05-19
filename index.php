<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>AnnonceExpress</title>
	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
			font-family: Arial, sans-serif;
		}

		body {
			background-color: #f5f5f5;
			color: #333;
		}

		header {
			background-color: #fff;
			padding: 20px 40px;
			box-shadow: 0 2px 5px rgba(0,0,0,0.1);
		}

		header h1 {
			color: #e74c3c;
			font-size: 28px;
		}

		.container {
			max-width: 1100px;
			margin: 30px auto;
			padding: 0 20px;
		}

		.formulaire {
			background-color: #fff;
			padding: 25px;
			border-radius: 8px;
			box-shadow: 0 2px 5px rgba(0,0,0,0.08);
			margin-bottom: 30px;
		}

		.formulaire h2 {
			margin-bottom: 20px;
			color: #e74c3c;
		}

		.formulaire input[type="text"],
		.formulaire input[type="number"],
		.formulaire textarea {
			width: 100%;
			padding: 10px;
			margin-bottom: 12px;
			border: 1px solid #ddd;
			border-radius: 5px;
			font-size: 14px;
		}

		.formulaire textarea {
			height: 80px;
			resize: vertical;
		}

		.formulaire input[type="submit"] {
			background-color: #e74c3c;
			color: #fff;
			border: none;
			padding: 10px 25px;
			border-radius: 5px;
			cursor: pointer;
			font-size: 15px;
		}

		.formulaire input[type="submit"]:hover {
			background-color: #c0392b;
		}

		h2.titre-liste {
			margin-bottom: 20px;
			color: #333;
		}

		.grille {
			display: grid;
			grid-template-columns: repeat(3, 1fr);
			gap: 20px;
		}

		.carte {
			background-color: #fff;
			border-radius: 8px;
			box-shadow: 0 2px 5px rgba(0,0,0,0.08);
			overflow: hidden;
		}

		.carte img {
			width: 100%;
			height: 180px;
			object-fit: cover;
		}

		.carte-info {
			padding: 15px;
		}

		.carte-info h3 {
			font-size: 16px;
			margin-bottom: 5px;
		}

		.carte-info p {
			font-size: 13px;
			color: #777;
			margin-bottom: 8px;
		}

		.carte-info .prix {
			font-size: 18px;
			font-weight: bold;
			color: #e74c3c;
			margin-bottom: 5px;
		}

		.carte-info .categorie {
			display: inline-block;
			background-color: #f0f0f0;
			padding: 3px 8px;
			border-radius: 10px;
			font-size: 12px;
			margin-bottom: 10px;
		}

		.carte-actions {
			display: flex;
			gap: 10px;
			padding: 10px 15px;
			border-top: 1px solid #eee;
		}

		.carte-actions a {
			text-decoration: none;
			padding: 6px 12px;
			border-radius: 5px;
			font-size: 13px;
		}

		.btn-suppr {
			background-color: #fee;
			color: #e74c3c;
		}

		.btn-modif {
			background-color: #eef;
			color: #3498db;
		}

		.btn-suppr:hover { background-color: #fdd; }
		.btn-modif:hover { background-color: #dde; }
	</style>
</head>
<body>

	<header>
		<h1>AnnonceExpress</h1>
	</header>

	<div class="container">

	<?php

		$bdd = new mysqli("localhost","root","","annonce_express");

		function selectAllAnnonce($bdd)
		{
			$select = "select * from annonce";
			$stmt = $bdd->prepare($select);
			$stmt->execute();
			$lesResultats = $stmt->get_result();
			return $lesResultats;
		}

		function insertAnnonce($bdd, $titre, $description, $prix, $categorie, $photo)
		{
			$insert = "insert into annonce values(null,?,?,?,?,?)";
			$stmt = $bdd->prepare($insert);
			$stmt->bind_param("ssdss", $titre, $description, $prix, $categorie, $photo);
			$stmt->execute();
			header("Location: http://localhost/AnnonceExpress/index.php");
		}

		function deleteAnnonce($bdd, $id)
		{
			$delete = "delete from annonce where idannonce=?";
			$stmt = $bdd->prepare($delete);
			$stmt->bind_param("i", $id);
			$stmt->execute();
		}

		if (isset($_GET['action']) && $_GET['action'] == "suppr") {
			$id = $_GET['id'];
			deleteAnnonce($bdd, $id);
		}

		if (isset($_POST['poster'])) {
			$titre = $_POST['titre'];
			$description = $_POST['description'];
			$prix = $_POST['prix'];
			$categorie = $_POST['categorie'];

			$photoname = basename($_FILES['photo']['name']);
			$dossier = 'images/';

			if (!is_dir($dossier)) {
				mkdir($dossier);
			}

			$destination = $dossier . $photoname;
			move_uploaded_file($_FILES['photo']['tmp_name'], $destination);

			insertAnnonce($bdd, $titre, $description, $prix, $categorie, $destination);
			exit();
		}

	?>

		<div class="formulaire">
			<h2>Poster une annonce</h2>
			<form method="post" enctype="multipart/form-data">
				<input type="text" name="titre" placeholder="Titre"><br>
				<textarea name="description" placeholder="Description"></textarea><br>
				<input type="number" name="prix" placeholder="Prix en €" step="0.01"><br>
				<input type="text" name="categorie" placeholder="Catégorie"><br>
				<label>Photo :</label>
				<input type="file" name="photo"><br><br>
				<input type="submit" name="poster" value="Poster l'annonce">
			</form>
		</div>

		<h2 class="titre-liste">Les annonces</h2>
		<div class="grille">

		<?php

		$lesResultats = selectAllAnnonce($bdd);

		foreach ($lesResultats as $unResultat) {
			echo '
			<div class="carte">
				<img src="' . $unResultat["photo"] . '" onerror="this.style.display=\'none\'">
				<div class="carte-info">
					<h3>' . $unResultat["titre"] . '</h3>
					<p>' . $unResultat["description"] . '</p>
					<div class="prix">' . $unResultat["prix"] . ' €</div>
					<span class="categorie">' . $unResultat["categorie"] . '</span>
				</div>
				<div class="carte-actions">
					<a class="btn-suppr" href="index.php?action=suppr&id=' . $unResultat["idannonce"] . '">Supprimer</a>
					<a class="btn-modif" href="modifier.php?action=modif&id=' . $unResultat["idannonce"] . '&titre=' . $unResultat["titre"] . '&description=' . $unResultat["description"] . '&prix=' . $unResultat["prix"] . '&categorie=' . $unResultat["categorie"] . '">Modifier</a>
				</div>
			</div>';
		}

		?>

		</div>
	</div>

</body>
</html>