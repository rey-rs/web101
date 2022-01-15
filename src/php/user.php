<?php 
	require ('conn.php');
	
	if($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action']=="register"){
		$pdo->beginTransaction();
		try {
			$sql = 'INSERT INTO user(idnumber, firstname, lastname, gender, bday, program, yearlevel) VALUES(:idnumber, :firstname, :lastname, :gender, :bday, :program, :yearlevel)';
			$statement = $pdo->prepare($sql);
			$statement->execute([
				':idnumber' => $_POST['userdata']['idnumber'],
				':firstname' => $_POST['userdata']['firstname'],
				':lastname' => $_POST['userdata']['lastname'],
				':gender' => (int) $_POST['userdata']['gender'],
				':bday' => $_POST['userdata']['bday'],
				':program' => $_POST['userdata']['program'],
				':yearlevel' => (int) $_POST['userdata']['yearlevel'],
			]);

			echo $pdo->lastInsertId();
			$pdo->commit();
		} catch (Exception $e) {
			$pdo->rollback();
		}
	}
	else if($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['action']=="getusers"){
		$sql = "SELECT * FROM user";
		$statement = $pdo->query($sql);
		$users = $statement->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($users);
	}

	else if($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['action'] == "get_ID"){
		$pdo->beginTransaction();
		try {
	        
			$sql = 'DELETE FROM user
	        WHERE id = :userID';

	        $statement = $pdo->prepare($sql);
			$statement->bindParam(':userID', $id, PDO::PARAM_INT);

			$statement->execute([
				':userID' => $_GET['userID']
			]);

			$pdo->commit();
		} catch (Exception $e) {
			$pdo->rollback();
		}

	}

	else if($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] == "update"){ 
		$pdo->beginTransaction();
		try {

			$sql = 'UPDATE user
			SET idnumber =:idnumber, firstname =:firstname, lastname =:lastname, gender =:gender, bday =:bday, program =:program, yearlevel =:yearlevel
			WHERE id = :id';

			$statement = $pdo->prepare($sql);

			$statement->bindParam(':id', $id, PDO::PARAM_INT);
			$statement->bindParam(':idnumber', $_POST['userdata']['idnumber']);
			$statement->bindParam(':firstname', $_POST['userdata']['firstname']);
			$statement->bindParam(':lastname', $_POST['userdata']['lastname']);
			$statement->bindParam(':gender', $_POST['userdata']['gender']);
			$statement->bindParam(':bday', $_POST['userdata']['bday']);
			$statement->bindParam(':program', $_POST['userdata']['program']);
			$statement->bindParam(':yearlevel', $_POST['userdata']['yearlevel']);


			if ($statement->execute([
				':id' => $_POST['userdata']['id'],
				':idnumber' => $_POST['userdata']['idnumber'],
				':firstname' => $_POST['userdata']['firstname'], 
				':lastname' => $_POST['userdata']['lastname'],
				':gender' => $_POST['userdata']['gender'],
				':bday' => $_POST['userdata']['bday'],
				':program' => $_POST['userdata']['program'],
				':yearlevel' => $_POST['userdata']['yearlevel'],
				])){
					echo 'The publisher has been updated successfully!';
				}

			$pdo->commit();
		} catch (Exception $e) {
			$pdo->rollback();
		}
	}

 ?>