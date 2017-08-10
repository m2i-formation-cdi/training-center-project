<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title><?= $pageTitle ?? "Titre par défaut"?></title>
    <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.theme.min.css">
</head>
<body class="container-fluid">

<div class="row">
    <?php if(isset($_SESSION["flash"])):?>
        <div class="alert alert-info col-md-6 col-md-offset-3">
            <?php
            echo $_SESSION["flash"];
            unset($_SESSION["flash"]);
            ?>
        </div>
    <?php endif; ?>
    <div class="col-md-8 col-md-offset-2">
        <?=$viewContent?>
    </div>
</div>


<script src="/bower_components/jquery/dist/jquery.min.js"></script>
<script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>