<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="/favicon.ico">

    <title><?php $view['slots']->output('title', 'service.myproject.ll') ?></title>

    <link href="/css/styles.css" rel="stylesheet">
</head>
<body>
    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="title m-b-md">
                <?php $view['slots']->output('_content') ?>
            </div>
        </div>
    </div>

    <script src="/js/app.js"></script>
</body>
</html>