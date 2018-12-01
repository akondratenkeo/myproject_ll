<?php $view->extend('frontend/_layout.html.php') ?>

<?php $view['slots']->set('title', 'Home Page') ?>

<?php $view['slots']->set('action-header', 'Articles') ?>

<?php $view['slots']->start('bg-container-content') ?>
    <img src="/images/home-bg.png" class="img-fluid mb-4" alt="home-bg.png">
<?php $view['slots']->stop() ?>

<?php $view['slots']->start('sidebar-content') ?>
    <div class="p-3 mb-3 bg-light rounded">
        <div class="avatar-container">
            <img src="/images/AK3187_circle.png" class="img-fluid" alt="AK3187_circle.png">
        </div>
        <blockquote class="blockquote">
            <p class="mb-0">Hi, all!</p>
            <footer class="blockquote-footer"><i>My name is Aleksandr Kondratenko and this is my final project for OWOX PHP School</i></footer>
        </blockquote>
    </div>

    <div class="p-3">
        <h4 class="font-italic">Archives</h4>
        <ol class="list-unstyled mb-0">
            <li><a href="#">March 2014</a></li>
            <li><a href="#">February 2014</a></li>
            <li><a href="#">January 2014</a></li>
            <li><a href="#">December 2013</a></li>
            <li><a href="#">November 2013</a></li>
            <li><a href="#">October 2013</a></li>
            <li><a href="#">September 2013</a></li>
            <li><a href="#">August 2013</a></li>
            <li><a href="#">July 2013</a></li>
            <li><a href="#">June 2013</a></li>
            <li><a href="#">May 2013</a></li>
            <li><a href="#">April 2013</a></li>
        </ol>
    </div>

    <div class="p-3">
        <h4 class="font-italic">Elsewhere</h4>
        <ol class="list-unstyled">
            <li><a href="#">GitHub</a></li>
            <li><a href="#">Twitter</a></li>
            <li><a href="#">Facebook</a></li>
        </ol>
    </div>
<?php $view['slots']->stop() ?>

<div class="home-page">
    <div class="articles-list">
        <?php foreach ($articles as $article) : ?>
            <div class="article-item">
                <div class="article-date">
                    <div class="article-date-container">
                        <span class="month-day"><?= "{$article->formatDate('M d')}" ?></span>
                        <span class="year"><?= "{$article->formatDate('Y')}" ?></span>
                    </div>
                </div>
                <div class="article-info">
                    <h6 class="article-item-title">
                        <a href="<?= "/article/{$article->id}"; ?>"><?= $article->title; ?></a>
                    </h6>
                    <p class="article-item-description">
                        <?= $article->description; ?>
                    </p>
                    <p class="article-item-meta">
                        <?= "by <span class=\"author-info\">{$article->author_name}</span><span class=\"visited-info\"><i class=\"fa fa-eye\"></i>{$article->visited}</span>"; ?>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <nav class="articles-pagination">
        <a class="btn btn-outline-dark disabled" href="#"><span aria-hidden="true">←</span> Previous</a>
        <a class="btn btn-outline-primary" href="#">Next <span aria-hidden="true">→</span></a>
    </nav>
</div>