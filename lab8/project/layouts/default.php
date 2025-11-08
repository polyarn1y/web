<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="/project/webroot/styles.css">
        <title><?= htmlspecialchars($title) ?></title>
    </head>
    <body>
        <header>
            хедер сайта
        </header>
        <div class="container">
            <aside class="sidebar left">
                левый сайдбар
            </aside>
            <main>
                <?= $content ?>
								<img src="project/webroot/images.png" alt="">
            </main>
            <aside class="sidebar right">
                правый сайдбар
            </aside>
        </div>
        <footer>
            футер сайта
        </footer>
    </body>
</html>