<?php

require 'init.php';
require 'templates/layout.php';

// Query database for all projects
if ($pdo) {

  $sql = '
    SELECT projects.id, projects.title, projects.description, 
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

<h2 class="text-center mt-5">All Projects</h2>

<?php foreach ($projects as $project) : ?>
<div class="container mt-5 mb-3">
  <div>
    <div class="d-flex flex-row staticRow">
      <div class="p-2 w-25 d-flex justify-content-center titleRow">Title</div>
      <div class="p-2 w-75 d-flex justify-content-center">Description</div>
    </div>
    <div class="d-flex flex-row dynamicRow">
      <div class="p-2 w-25 d-flex justify-content-center align-items-center titleRow">
        <?php if ($_SESSION['user'] === $project['username']): ?>
          <a href="edit.php?id=<?=$project['id']?>"><?=htmlspecialchars($project['title']);?></a>
        <?php else: ?>
            <?=htmlspecialchars($project['title']);?>
        <?php endif ?>
      </div>
      <div class="p-2 w-75 d-flex justify-content-center">
        <?= htmlspecialchars($project['description']); ?>
      </div>
    </div>
    <div class="d-flex justify-content-around flex-row dynamicRow">
      <div class="p-2 "><?= htmlspecialchars($project['status']); ?> </div>
      <div class="p-2"><?= htmlspecialchars($project['create_date']); ?></div>
      <div class="p-2"><?= htmlspecialchars($project['username']); ?></div>
    </div>
  </div>
</div>
<?php endforeach; ?>
