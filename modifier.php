<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Modifier une annonce</title>
</head>
<body>

	<h1>Modifier une annonce</h1>

	<form method="post" enctype="multipart/form-data">

		<input type="text" name="titre" placeholder="Titre" value="<?php echo isset($_GET['titre']) ? $_GET['titre'] : "" ; ?>"><br><br>
		<textarea name="description" placeholder="Description"><?php echo isset($_GET['description']) ? $_GET['description'] : "" ; ?></textarea><br><br>
		<input type="number" name="prix" placeholder="Prix en €" step="0.01" value="<?php echo isset($_GET['prix']) ? $_GET['prix'] : "" ; ?>"><br><br>
		<input type="text" name="categorie" placeholder="Catégorie" value="<?php echo isset($_GET['categorie']) ? $_GET['categorie'] : "" ; ?>"><br><br>
		<label>Photo :</label>
		<input type="file" name="photo"><br><br>
		<input type="submit" name="modifier" value="Modifier">

	</form>

	<?php

		$bdd = new mysqli("localhost","root","","annonce_express");

		function updateAnnonce($bdd, $id, $titre, $description, $prix, $categorie, $photo)
		{
			$update = "update annonce set titre=?,description=?,prix=?,categorie=?,photo=? where idannonce=?";
			$stmt = $bdd->prepare($update);
			$stmt->bind_param("ssdssi", $titre, $description, $prix, $categorie, $photo, $id);
			$stmt->execute();

			header("Location: index.php");
		}

		if (isset($_POST['modifier'])) {

			$photoname = basename($_FILES['photo']['name']);
			$dossier = 'images/';

			if (!is_dir($dossier)) {
				mkdir($dossier);
			}

			$destination = $dossier . $photoname;
			move_uploaded_file($_FILES['photo']['tmp_name'], $destination);

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