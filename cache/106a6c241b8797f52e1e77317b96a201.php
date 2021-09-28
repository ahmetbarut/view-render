<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=$lorems?></title>
</head>
<body>
    <div>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae doloribus ea explicabo facere mollitia nemo provident reprehenderit sint. Amet corporis cumque ea exercitationem explicabo ipsa ipsam nesciunt perspiciatis quam tempore.
    </div>

    <div>
        <?=$echo?>
        <?=strtoupper($echo)?>
        <?php foreach($todos as $key => $todo): ?>
        <?=$todo?> <br>
            <?php if($key === 1): ?>
                <h1><?=$key?> DDD</h1>
            <?php else: ?>
                <h4>Key 1'den büyük:d</h4>
            <?php endif; ?>
        <?php endforeach; ?>

        <?= print_r(explode(",","loremipsum, uzunlar, yanıyor, bu")); ?>
    </div>
    <footer> ss
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab aliquam aperiam autem cum debitis error facilis nam quia vel, voluptas. Adipisci beatae error id itaque iusto nulla perferendis possimus voluptas.
    </footer>
</body>
</html>