<?php

  require "database.php";

  $error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if ( empty($_POST["email"]) || empty($_POST["password"]) ){
    $error = "Please fill all fields.";
  }
  else if (!str_contains($_POST["email"], "@")) {
    /**< Lib to validate email can be use. */
    $error = "Email format is incorrect.";
  }
  else {
    $statement = $conn->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
    $statement->execute( [":email" => $_POST["email"]] );

    if ($statement->rowCount() == 0) {
      $error = "Invalid credentials.";
    }
    else {
      $user = $statement->fetch(PDO::FETCH_ASSOC);
      /**< Validate user credentials with the one stored in DB */
      if (!password_verify($_POST["password"], $user["password"])) {
        $error = "Invalid credentials.";
      }
      else {
        /**< User correct, start session */
        /**< If you does not have a session, this will crease one */
        /**< If you have it, the browser will send the cooky with the session ID */
        session_start();
        /**< Remove password from $user variable */
        unset($user["password"]);
        /**< Store user in logal variable _SESSION */
        $_SESSION["user"] = $user;
        header("Location: home.php");
      }
    }
  }
}
else {
  /**< NO POST method */
}

?>

<?php require "partial/header.php" ?>

<div class="container pt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Login</div>
        <div class="card-body">
          <?php if ($error): ?>
            <p class="text-danger">
              <?= $error ?>
            </p>
          <?php endif ?>
          <form method="POST" action="login.php">

            <div class="mb-3 row">
              <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>

              <div class="col-md-6">
                <input id="email" type="email" class="form-control" name="email" required autocomplete="emial" autofocus>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>

              <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password" required autocomplete="password" autofocus>
              </div>
            </div>

            <div class="mb-3 row">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require "partial/footer.php" ?>
