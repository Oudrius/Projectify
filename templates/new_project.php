<?php

// Load requirements
require '../init.php';
require 'layout.php';

// Set arrays for user errors and inputs
$errors = ["title" => '', "description" => ''];
$inputs = ["title" => '', "description" => ''];


// Page reached via POST method
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Validate and sanitize title
    $title = $inputs['title'] = htmlspecialchars(trim($_POST['title']));
    if (mb_strlen($title) < 10 || mb_strlen($title) > 80) {
        $errors['title'] = 'Title length must be 10-80 characters long.'; 
    }
    // Validate and sanitize description
    $description = $inputs['description'] = htmlspecialchars(trim($_POST['description']));
    if (mb_strlen($description) > 500) {
        $errors['description'] = 'Description length cannot exceed 500 characters';
    }

    // Get user id from database
    try {
        $sql = "SELECT id FROM users
        WHERE username = :username";

        $statement = $pdo->prepare($sql);
        $statement->bindParam(':username', $_SESSION['user'], PDO::PARAM_STR);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC); // Returns associative array

    } catch (PDOException $e) {
        echo "Could not retrieve user id from database. " . $e->getMessage();
    }


    // Make a new database entry
    if (implode($errors) === '') { // If no errors

        try {
            $sql = '
            INSERT INTO projects 
            (title, description, user_id)
            VALUES (:title, :description, :user_id)
            ';
            $statement = $pdo->prepare($sql);
            $statement->execute([
                ':title' => $title,
                ':description' => $description,
                ':user_id' => $user['id']
            ]);
            header('Location: my_projects.php');
            die;
            
        } catch (PDOException $e) {
            echo "Could not create a database entry. " . $e->getMessage();
        }
    }
}


?>

<body>
  <div class="container mt-5">
    <h3 class="mb-5 text-center">New Project</h3>
    <form action="new_project.php" method="post">
      <div class="mb-3">
        <label for="title" class="form-label">Project title</label>
<?php if (!$errors['title']): ?>
        <input type="text" class="form-control" id="title" name="title" placeholder="10-80 characters" aria-describedby="projectTitle" value="<?= htmlspecialchars($inputs['title']) ?>" autofocus>
<?php else: ?>
        <input type="text" class="form-control is-invalid" id="title" name="title" placeholder="10-80 characters" aria-describedby="projectTitle" value="<?= htmlspecialchars($inputs['title']) ?>" autofocus>
        <div class="invalid-feedback"><?= htmlspecialchars($errors['title']) ?></div>
<?php endif ?>
        <div id="projectTitle" class="form-text">Enter the title for your project.</div>
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Project description</label>
<?php if (!$errors['description']): ?>
        <input type="text" class="form-control" id="description" name="description" placeholder="Maximum 500 characters" aria-describedby="projectDescription" value="<?= htmlspecialchars($inputs['description']) ?>">
<?php else: ?>
        <input type="text" class="form-control is-invalid" id="description" name="description" placeholder="Maximum 500 characters" aria-describedby="projectDescription" value="<?= htmlspecialchars($inputs['description']) ?>">
        <div class="invalid-feedback"><?= htmlspecialchars($errors['description']) ?></div>
<?php endif ?>
        <div id="projectDescription" class="form-text">Describe your project.</div>
      </div>
      <button type="submit" class="btn btn-primary">Add project</button>
    </form>
  </div>
</body>