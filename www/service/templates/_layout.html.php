<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="/favicon.ico">

    <title><?php $view['slots']->output('title', '') ?></title>
    <script src="//service.myproject.ll:6001/socket.io/socket.io.js"></script>

    <link href="/css/styles.css" rel="stylesheet">
</head>
<body>
<div id="app">
    <header class="frontend-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="frontend-header-link-wrapper border-bottom text-center">
                        <a class="frontend-header-logo" href="/">MyProject.ll</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main class="frontend-main">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-8 content-main">
                    <div class="action-menu-block">
                        <?php $view['slots']->output('action-menu', '') ?>
                    </div>

                    <?php $view['slots']->output('_content') ?>
                </div>
                <aside class="col-12 col-lg-4 content-sidebar">
                    <?php $view['slots']->output('sidebar-content') ?>
                </aside>
            </div>
        </div>
    </main>
    <footer class="frontend-footer">
        <p>Built by <span class="author-sign">Aleksandr Kondratenko</span> for <u>OWOX PHP School</u>.</p>
    </footer>
</div>

<script src="/js/bootstrap.js"></script>
<script src="/js/app.js"></script>

</body>
</html>