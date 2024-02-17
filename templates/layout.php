<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/task_manager/static/styles/styles.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <title>Projectify</title>
<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="/task_manager/">Projectify</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav">
<?php if (isset($_SESSION['user'])): ?>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="/task_manager/templates/my_projects.php">My Projects</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/task_manager/templates/new_project.php">New Project</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/task_manager/templates/logout.php">Log out</a>
            </li>
<?php else: ?>
            <li class="nav-item">
              <a class="nav-link" href="/task_manager/templates/login.php">Log in</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/task_manager/templates/register.php">Register</a>
            </li>
<?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>
  </header>
</body>
</html>