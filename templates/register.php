<?php

require 'layout.php';
$pdo = require '../init.php';

// Initialize errors and inputs arrays to use in HTML form
$errors = ['username' => '', 'password' => '', 're-password' => ''];
$inputs = ['username' => '', 'password' => ''];

var_dump($pdo);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === 'POST') {

    // Sanitize and validate username input
    $username = $inputs['username'] = trim(filter_input(INPUT_POST, 'username')); // Sanitize username input

    if (mb_strlen($username) >=4 && mb_strlen($username) <= 16) { // Validate length

        // Query DB for duplicate usernames
        $sql = 'SELECT * FROM users
                WHERE username = :username;';
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':username', $username, PDO::PARAM_STR);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC); // Returns associated array of 'users' table

        // Set user errors
        if ($user) {
            $errors['username'] = 'Username already exists';
        }
    } else {
        $errors['username'] = 'Username must be 4-16 characters long.';
    }

    // Sanitize and validate password input
    $password = $inputs['password'] = filter_input(INPUT_POST, 'password'); // Sanitize password input

    // Validate length
    if (strlen($password) <8) {
        $errors['password'] = 'Password is too short.';
    } else if (strlen($password) > 64) {
        $errors['password'] = 'Password is too long.';
    }

    $re_password =  filter_input(INPUT_POST, 're-password'); // Sanitize password input
    if ($password !== $re_password) { // Check for password match
        $errors['re-password'] = 'Passwords do not match.';
    }
    
    // Proccess data
    if (implode($errors) === '') { // If no errors

        $hash = password_hash($password, PASSWORD_DEFAULT); // Hash password

        // Create new row in 'users' table
        $sql = 'INSERT INTO users (username, password) 
                VALUES (:username, :password)';
        $statement = $pdo->prepare($sql);
        $statement->execute([
            ':username' => $username,
            ':password' => $hash
        ]);

        header('Location: ../'); // Redirect to index page
        die; // Terminate this script
    }
}

?>

<body>
  <div class="container mt-5">
    <div class="mb-3">
      <div class="row justify-content-center">
        <div class="col-md-6">
        <h3 class="text-center">Create an account</h3>
          <form action="register.php" method="post">
            <div class="mb-3 mt-3">
              <label for="username" class="form-label">Username</label>
<?php if (!$errors['username']): ?>
              <input type="text" class="form-control" id="username" name="username">
<?php else: ?>
              <input type="text" class="form-control is-invalid" id="username" name="username" value="<?= htmlspecialchars($inputs['username']) ?>">
              <div class="invalid-feedback"><?= htmlspecialchars($errors['username']) ?></div>
<?php endif ?>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
<?php if (!$errors['password']): ?>
              <input type="password" class="form-control" id="password" name="password">
<?php else: ?>
              <input type="password" class="form-control is-invalid" id="password" name="password" value="<?= htmlspecialchars($inputs['password']) ?>">
              <div class="invalid-feedback"><?= htmlspecialchars($errors['password']) ?></div>
<?php endif ?>
            </div>
            <div class="mb-3">
              <label for="re-password" class="form-label">Repeat Password</label>
<?php if (!$errors['re-password']): ?>
                <input type="password" class="form-control" id="re-password" name="re-password">
<?php else: ?>
                <input type="password" class="form-control is-invalid" id="re-password" name="re-password">
                <div class="invalid-feedback"><?= htmlspecialchars($errors['re-password']) ?></div>
<?php endif ?>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>