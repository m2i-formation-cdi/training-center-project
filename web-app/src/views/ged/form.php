
<h1>Ajout d'un nouveau document</h1>

<!-- Affichage des erreurs -->
<?php if(count($errors) >0): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $item): ?>
                <li><?=$item?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data" novalidate>
    <div class="form-group">
        <label for="title">Titre du document</label>
        <input type="text" name="title" id="title" required class="form-control">
    </div>
    <div class="form-group">
        <label for="docFile">Téléchargement du document</label>
        <input type="file" name="docFile" id="docFile" required class="form-control">
    </div>

    <div class="form-group">
        <button type="submit" name="submit" class="btn btn-primary">Valider</button>
    </div>
</form>