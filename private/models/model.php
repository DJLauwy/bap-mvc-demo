<?php
// Model functions
// In dit bestand zet je ALLE functions die iets met data of de database doen

function getUsers() {
	$connection = dbConnect();
	$sql        = "SELECT * FROM `users`";
	$statement  = $connection->query( $sql );

	return $statement->fetchAll();
}

function getUserByCode($code){
	$connection = dbConnect();
	$sql = "SELECT * FROM `gebruikers` WHERE code = :code";
	$statement = $connection->prepare($sql);
	$statement->execute(['code' => $code]);
	if ($statement->rowCount() === 1){
		return $statement->fetch();
	}
	return false;
}