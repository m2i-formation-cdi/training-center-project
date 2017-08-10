<h1>Bonjour <?=$name?></h1>


    <?php foreach ($list as $fileName): ?>
        <li>
            <a href="/app.php?c=download&file=<?=$fileName?>" >
            <?=$fileName?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>