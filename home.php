
<?php 

require "database.php";

session_start();
/**< Detect if user logged */
if (!isset($_SESSION["user"])) {
  header("Location: login.php");
  return;
}

$contacts = $conn->query("SELECT * FROM contacts WHERE user_id = {$_SESSION['user']['id']}");

?>


<?php require "partial/header.php" ?>

      <div class="container pt-4 p-3">
        <div class="row">

          <?php if ($contacts->rowCount() == 0): ?>
            <div class="col-md-4 mb-3">
              <div class="card text-center">
                <div class="card-body">
                  <p>No contacts saved yet</p>
                  <a href="/contacts-app/add.php">Add one!</a>
                </div>
              </div>
            </div>
          <?php endif ?>

          <?php foreach ($contacts as $contact): ?>
            <div class="col-md-4 mb-3">
              <div class="card text-center">
                <div class="card-body">
                  <!-- Protect from XSS not included-->
                  <h3 class="card-title text-capitalize"><?= htmlspecialchars($contact["name"]) ?></h3>
                  <h5>Phone number:</h5>
                  <p class="m-2"><?= htmlspecialchars($contact["phone_number"]) ?></p>

                  <!-- Show addresses -->
                  <div class="mt-3">
                    <h5>Addresses:</h5>
                    <?php 
                      $statement = $conn->prepare("SELECT address FROM contact_address WHERE user_id = :contact_id LIMIT 10");
                      $statement->bindParam(":contact_id", $contact["id"]);
                      $statement->execute();
                      $addresses = $statement->fetchAll(PDO::FETCH_ASSOC);
                    ?>

                    <?php if (count($addresses) == 0): ?>
                      <p class="text-muted">No address associated</p>
                    <?php else: ?>
                      <ul class="list-unstyled">
                        <?php foreach ($addresses as $address): ?>
                          <!-- Protect from XSS -->
                          <li><?= htmlspecialchars($address["address"]) ?></li>
                        <?php endforeach ?>
                      </ul>
                    <?php endif ?>
                  </div>

                  <!-- Buttons -->
                   <!-- TODO: Edit addresses -->
                  <a href="edit.php?id=<?= $contact["id"] ?>" class="btn btn-secondary mb-2">Edit Contact</a>
                  <a href="delete.php?id=<?= $contact["id"] ?>" class="btn btn-danger mb-2">Delete Contact</a>
                </div>
              </div>
            </div>
          <?php endforeach ?>

        </div>
      </div>

<?php require "partial/footer.php" ?>