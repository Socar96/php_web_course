<?php
require "database.php";

session_start();
if (!isset($_SESSION["user"])) {
  header("Location: login.php");
  return;
}

$statement = $conn->prepare("SELECT * FROM contacts WHERE id = :id LIMIT 1");
$statement->execute([":id" => $_GET["id"]]);
if ($statement->rowCount() == 0) {
  http_response_code(404);
  echo("HTTP 404 NOT FOUND\n");
  return;
}

$contact = $statement->fetch(PDO::FETCH_ASSOC);
/**< Does not allow user with different ID to delete a contact */
if ($contact["user_id"] !== $_SESSION["user"]["id"]) {
  http_response_code(403);
  echo("HTTP 403 UNAUTHORIZED");
  return;
}

$statement = $conn->prepare("DELETE FROM contacts WHERE id = :id")->execute([":id" => $_GET["id"]]);

$_SESSION["flash"] = ["message" => "Contact {$contact['name']} deleted."];

header("Location: home.php");

?>
