<?php $view->extend('frontend/_layout.html.php') ?>

<?php $view['slots']->set('title', $article->title) ?>

<?php $view['slots']->set('action-header', $article->title) ?>

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

    <articles-top-visited
        article-id="<?= $article->id; ?>"
        topic-id="<?= $article->topic_id; ?>"
    ></articles-top-visited>

<?php $view['slots']->stop() ?>

<div class="dashboard-index">
    <div class="articles-list">
        <div class="article-item">
            <div class="article-date">
                <div class="article-date-container">
                    <span class="month-day"><?= $article->formatDate('M d'); ?></span>
                    <span class="year"><?= $article->formatDate('Y'); ?></span>
                </div>
            </div>
            <div class="article-info">
                <p class="article-item-meta mb-3">
                    <?= "by <span class=\"author-info\">{$article->author_name}</span><span class=\"visited-info\"><i class=\"fa fa-eye\"></i>{$article->visited}</span>"; ?>
                </p>
                <p class="article-item-image">
                    <img src="/images/storage/<?= $article->image_filename; ?>" class="img-fluid" alt="">
                </p>
                <p class="article-item-description">
                    <?= $view->escape($article->body); ?>
                </p>
            </div>
        </div>
    </div>
</div>