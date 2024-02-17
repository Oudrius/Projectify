<?php

require 'init.php';
require 'templates/layout.php';

// Query database for all projects
if ($pdo) {

  $sql = '
    SELECT projects.title, projects.description, 
    projects.create_date, projects.status, projects.user_id, users.username
    FROM projects
    INNER JOIN users ON projects.user_id = users.id
    ;';
  $statement = $pdo->query($sql);
  $projects = $statement->fetchAll(PDO::FETCH_ASSOC);
} else {
  echo "Could not connect to database.";
}

?>

<?php foreach ($projects as $project) : ?>
  <div class="container mt-3 mb-5 mt-md-5" id="outerContainer">
    <div class="row text-center">
      <div class="col-sm col-md-3 pb-3 pb-md-1" id="title">
        Title
      </div>
      <div class="col" id="description">
        Description
      </div>
    </div>
    <div class="row align-items-center">
      <div class="col-sm col-md-3 title pb-3 pb-md-1">
        <?= htmlspecialchars($project['title']); ?>
      </div>
      <div class="col">
        <?= htmlspecialchars($project['description']); ?>
      </div>
    </div>
    <div class="row pt-3 pt-md-1 align-items-center">
      <div class="col">
        <?= htmlspecialchars($project['status']); ?>
      </div>
      <div class="col">
        <?= htmlspecialchars($project['create_date']); ?>
      </div>
      <div class="col">
        <?= htmlspecialchars($project['username']); ?>
      </div>
    </div>
  </div>
<?php endforeach; ?>