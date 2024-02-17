<?php

require 'layout.php';
require '../init.php';

// Initialize errors array to use in HTML form
$errors = ['username' => '', 'password' => ''];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === 'POST') {

    // Sanitize and validate username input
    $username = htmlspecialchars(trim($_POST['username'])); // Sanitize username input

    if (mb_strlen($username) >=4 && mb_strlen($username) <= 16) { // Validate length

        // Query DB for duplicate usernames
        $sql = 'SELECT password FROM users
                WHERE username = :username;';
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':username', $username, PDO::PARAM_STR);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC); // Returns associated array of 'users' table
        
        // If query returned results
        if ($user) {
            $hash = $user['password']; // Set hash variable for clarity
        } else {
            $errors['username'] = "Username doesn't exist.";
        }

    // Set user errors
    } else {
        $errors['username'] = 'Invalid username and/or password.';
    }

    // Validate password input
    $password = $_POST['password'];

    // Validate length
    if (strlen($password) <8 || strlen($password) > 64) {
        $errors['password'] = 'Invalid username and/or password.';
    }
    
    // Proccess data
    if (implode($errors) === '') { // If no errors

        // Unhash and compare passwords
        if (password_verify($password, $hash)) {
            $_SESSION['user'] = $username; // Log user in

            header('Location: ../'); // Redirect to index page
            die; // Terminate this script

        } else {
            $errors['password'] = 'Invalid username and/or password.';
        }
    }
}

?>

<body>
  <div class="container mt-5">
    <div class="mb-3">
      <div class="row justify-content-center">
        <div class="col-md-6">
        <h3 class="text-center">Log in</h3>
          <form action="login.php" method="post">
            <div class="mb-3 mt-3">
              <label for="username" class="form-label">Username</label>
<?php if (!$errors['username']): ?>
              <input type="text" class="form-control" id="username" name="username" autofocus>
<?php else: ?>
              <input type="text" class="form-control is-invalid" id="username" name="username" value="<?= htmlspecialchars($username) ?>">
              <div class="invalid-feedback"><?= htmlspecialchars($errors['username']) ?></div>
<?php endif ?>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
<?php if (!$errors['password']): ?>
              <input type="password" class="form-control" id="password" name="password">
<?php else: ?>
              <input type="password" class="form-control is-invalid" id="password" name="password">
              <div class="invalid-feedback"><?= htmlspecialchars($errors['password']) ?></div>
<?php endif ?>
            </div>
            <button type="submit" class="btn btn-primary">Log in</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>