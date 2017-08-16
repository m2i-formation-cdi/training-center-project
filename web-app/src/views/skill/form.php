<!-- Affichage des erreurs -->
<?php if(count($errors)): ?>
    <div>
        <ul>
            <?php foreach ($errors as $item): ?>
                <li class="text-danger"><?= $item; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<?php if (isset($message)):?>
    <p class="bg-success"><?=$message?></p>
<?php endif; ?>
<form method="post" class="form-inline">
    <fieldset>
        <legend>Ajouter une nouvelle compétence</legend>
    <div class="form-group <?php if (count($errors)) echo 'has-error'; else echo ''; ?>">
        <label for="skillName">Taper la compétence</label>
        <input type="text" id="skillName" name="skillName" class="form-control">
    </div>
    <div class="form-group">
        <button type="submit" name="submit" class="btn bg-primary">Ajouter</button>
    </div>
    </fieldset>
</form>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Compétences</th>
        </tr>
    </thead>
    <tbody>
    <?php if (count($skills)):?>
        <?php foreach ($skills as $item):?>
            <tr>
                <td><?=$item['skillName']?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>