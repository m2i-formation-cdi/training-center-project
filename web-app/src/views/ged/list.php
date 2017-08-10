<ul>
    <?php foreach ($documentList as $document): ?>
        <li>
            <a href="/uploadedDocs/<?=$document["file"]?>" download>
                <?=$document["title"]?>
            </a>
        </li>
    <?php endforeach;?>
</ul>