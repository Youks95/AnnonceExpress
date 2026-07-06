<?php

// ========== SESSION ==========

	session_start();

	if (!isset($_SESSION['iduser'])) {
		header("Location: connexion.php");
		exit();
	}

// ========== CONNEXION BDD ==========

	$bdd = new mysqli("localhost","root","","annonce_express");

// ========== FONCTION ==========

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
		exit();
	}

// ========== ACTION ==========

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
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Modifier une annonce</title>

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
		}

		header {
			background: linear-gradient(135deg, #ff6b4a, #ff8f6b);
			padding: 20px 40px;
			display: flex;
			justify-content:
