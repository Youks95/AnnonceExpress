<?php

	$bdd = new mysqli("localhost","root","","annonce_express");

	function selectAllAnnonce($bdd)
	{
		//requete
		$select = "select * from annonce";
		//preparer la requete
		$stmt = $bdd->prepare($select);
		//executer la requete
		$stmt->execute();
		$lesResultats = $stmt->get_result();

		return $lesResultats;
	}

	function insertAnnonce($bdd, $titre, $description, $prix, $categorie, $photo)
	{
		//requete
		$insert = "insert into annonce values(null,?,?,?,?,?)";
		//preparer la requete
		$stmt = $bdd->prepare($insert);
		$stmt->bind_param("ssdss", $titre, $description, $prix, $categorie, $photo);
		//executer la requete
		$stmt->execute();

		header("Location: http://localhost/AnnonceExpress/index.php");
	}

	function deleteAnnonce($bdd, $id)
	{
		//requete
		$delete = "delete from annonce where idannonce=?";
		//preparer la requete
		$stmt = $bdd->prepare($delete);
		$stmt->bind_param("i", $id);
		//executer la requete
		$stmt->execute();
	}

	if (isset($_GET['action']) && $_GET['action'] == "suppr") {
		$id = $_GET['id'];
		deleteAnnonce($bdd, $id);
		header("Location: index.php");
		exit();
	}

	if (isset($_POST['poster'])) {
	$titre = $_POST['titre'];
	$description = $_POST['description'];
	$prix = $_POST['prix'];
	$categorie = $_POST['categorie'];

	if (!empty($_FILES['photo']['name'])) {
		$photoname = basename($_FILES['photo']['name']);
		$dossier = 'images/';

		if (!is_dir($dossier)) {
			mkdir($dossier);
		}

		$destination = $dossier . $photoname;
		move_uploaded_file($_FILES['photo']['tmp_name'], $destination);
	} else {
		$destination = null;
	}

	insertAnnonce($bdd, $titre, $description, $prix, $categorie, $destination);
	exit();
}
	$lesResultats = selectAllAnnonce($bdd);

?>
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
			font-family: 'Segoe UI', Arial, sans-serif;
		}

		body {
			background-color: #f7f8fa;
			color: #1f2937;
		}

		header {
			background: linear-gradient(135deg, #ff6b4a, #ff8f6b);
			padding: 20px 40px;
			box-shadow: 0 2px 10px rgba(255,107,74,0.25);
		}

		header h1 {
			color: #fff;
			font-size: 28px;
		}

		.container {
			max-width: 1100px;
			margin: 30px auto;
			padding: 0 20px;
		}

		.hero {
			text-align: center;
			margin-bottom: 25px;
		}

		.hero p {
			font-size: 16px;
			color: #4b5563;
			margin-bottom: 10px;
		}

		.badge-count {
			display: inline-block;
			background-color: #fff0eb;
			color: #ff6b4a;
			padding: 6px 16px;
			border-radius: 20px;
			font-size: 13px;
			font-weight: bold;
		}

		.formulaire {
			background-color: #fff;
			padding: 25px;
			border-radius: 10px;
			box-shadow: 0 2px 8px rgba(0,0,0,0.06);
			margin-bottom: 30px;
			border: 1px solid #e5e7eb;
			border-top: 4px solid #ff6b4a;
		}

		.formulaire h2 {
			margin-bottom: 20px;
			color: #1f2937;
			font-size: 20px;
		}

		.formulaire input[type="text"],
		.formulaire input[type="number"],
		.formulaire textarea {
			width: 100%;
			padding: 11px;
			margin-bottom: 12px;
			border: 1px solid #e5e7eb;
			border-radius: 6px;
			font-size: 14px;
			background-color: #fafafa;
		}

		.formulaire input[type="text"]:focus,
		.formulaire input[type="number"]:focus,
		.formulaire textarea:focus {
			outline: none;
			border-color: #ff6b4a;
			background-color: #fff;
		}

		.formulaire textarea {
			height: 80px;
			resize: vertical;
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
		}

		.formulaire input[type="submit"]:hover {
			background-color: #e8552f;
		}

		h2.titre-liste {
			margin-bottom: 20px;
			color: #1f2937;
			font-size: 20px;
		}

		.grille {
			display: grid;
			grid-template-columns: repeat(3, 1fr);
			gap: 20px;
		}

		.carte {
			background-color: #fff;
			border-radius: 10px;
			box-shadow: 0 2px 8px rgba(0,0,0,0.06);
			overflow: hidden;
			border: 1px solid #e5e7eb;
			transition: box-shadow 0.2s;
		}

		.carte:hover {
			box-shadow: 0 4px 14px rgba(0,0,0,0.1);
		}

		.carte img {
			width: 100%;
			height: 180px;
			object-fit: cover;
			background-color: #f0f0f0;
		}

		.no-photo {
			width: 100%;
			height: 180px;
			display: flex;
			align-items: center;
			justify-content: center;
			background: linear-gradient(135deg, #ffe0d6, #ffd1c2);
			color: #ff6b4a;
			font-size: 14px;
			font-weight: 500;
		}

		.carte-info {
			padding: 15px;
		}

		.carte-info h3 {
			font-size: 16px;
			margin-bottom: 5px;
			color: #1f2937;
		}

		.carte-info p {
			font-size: 13px;
			color: #6b7280;
			margin-bottom: 8px;
		}

		.carte-info .prix {
			font-size: 18px;
			font-weight: bold;
			color: #ff6b4a;
			margin-bottom: 8px;
		}

		.carte-info .categorie {
			display: inline-block;
			background-color: #eef2ff;
			color: #4338ca;
			padding: 3px 10px;
			border-radius: 12px;
			font-size: 12px;
			margin-bottom: 10px;
		}

		.carte-actions {
			display: flex;
			gap: 10px;
			padding: 12px 15px;
			border-top: 1px solid #f0f0f0;
		}

		.carte-actions a {
			text-decoration: none;
			padding: 6px 14px;
			border-radius: 6px;
			font-size: 13px;
			font-weight: 500;
		}

		.btn-suppr {
			background-color: #fee2e2;
			color: #dc2626;
		}

		.btn-modif {
			background-color: #dbeafe;
			color: #2563eb;
		}

		.btn-suppr:hover { background-color: #fecaca; }
		.btn-modif:hover { background-color: #bfdbfe; }
	</style>
</head>
<body>

	<header>
		<h1>AnnonceExpress</h1>
	</header>

	<div class="container">

		<div class="hero">
			<p>Trouvez ou vendez ce que vous voulez, simplement.</p>
			<span class="badge-count"><?php echo $lesResultats->num_rows; ?> annonce<?php echo $lesResultats->num_rows > 1 ? 's' : ''; ?> en ligne</span>
		</div>

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

		foreach ($lesResultats as $unResultat) {

			echo '<div class="carte">';

			if (!empty($unResultat["photo"])) {
				echo '<img src="' . $unResultat["photo"] . '">';
			} else {
				echo '<div class="no-photo">Pas de photo</div>';
			}

			echo '
				<div class="carte-info">
					<h3>' . $unResultat["titre"] . '</h3>
					<p>' . $unResultat["description"] . '</p>
					<div class="prix">' . $unResultat["prix"] . ' €</div>
					<span class="categorie">' . $unResultat["categorie"] . '</span>
				</div>
				<div class="carte-actions">
					<a class="btn-suppr" href="index.php?action=suppr&id=' . $unResultat["idannonce"] . '">Supprimer</a>
					<a class="btn-modif" href="modifier.php?action=modif&id=' . $unResultat["idannonce"] . '&titre=' . $unResultat["titre"] . '&description=' . $unResultat["description"] . '&prix=' . $unResultat["prix"] . '&categorie=' . $unResultat["categorie"] . '&photo=' . $unResultat["photo"] . '">Modifier</a>
				</div>
			</div>';
		}

		?>

		</div>
	</div>

</body>
</html>
