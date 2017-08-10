<h1>Liste des livres par auteur</h1>
<table class="table table-bordered">
    <thead>
    <!-- Affichage dynamique des colonnes -->
    <?php if (isset($bookList[0])): ?>
        <?php $cols = array_keys($bookList[0]); ?>
        <tr>
            <?php foreach ($cols as $colName): ?>
                <th> <?= $colName ?></th>
            <?php endforeach; ?>
        </tr>
    <?php endif; ?>
    </thead>
    <!-- Affichage des données -->
    <?php foreach ($bookList as $livre): ?>
        <tr>
            <?php foreach ($livre as $colData): ?>
                <td><?= $colData?></td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
</table>