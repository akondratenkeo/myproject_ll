<?php $view->extend('admin/_layout.html.php') ?>

<?php $view['slots']->set('title', 'Dashboard') ?>

<?php $view['slots']->set('action-header', 'Dashboard') ?>

<?php $view['slots']->start('action-menu') ?>
    <ul class="nav">
        <li class="nav-item">
            <a class="btn btn-primary" href="/article/new">Create new article</a>
        </li>
    </ul>
<?php $view['slots']->stop() ?>

<?php $view['slots']->start('sidebar-content') ?>
    <div class="stats-block">
        <h4 class="header">Topics</h4>
        <p class="info"><?= $topics_count; ?></p>
    </div>

    <div class="stats-block">
        <h4 class="header">Authors</h4>
        <p class="info"><?= $authors_count; ?></p>
    </div>

    <div class="stats-block">
        <h4 class="header">Articles</h4>
        <p class="info"><?= $articles_count; ?></p>
    </div>
<?php $view['slots']->stop() ?>

<div class="dashboard-index">
    <div class="articles-list">
        <?php foreach ($articles as $article) : ?>
            <div class="article-item">
                <h6 class="article-item-title">
                    <a href="<?= "/article/{$article->id}"; ?>"><?= "[id: {$article->id}] $article->title"; ?></a>
                    <button
                            class="btn btn-outline-danger delete-button"
                            @click="$bus.emit('delete-article', <?= $article->id; ?>)"
                    >
                        Delete
                    </button>
                </h6>
                <p class="article-item-meta">
                    <?= "{$article->formatDate('d F Y')}, by <span class=\"author-info\">{$article->author_name}</span><span class=\"visited-info\"><i class=\"fa fa-eye\"></i>{$article->visited}</span>"; ?>
                </p>
            </div>
        <?php endforeach; ?>
    </div>

    <nav class="articles-pagination">
        <a class="btn btn-outline-dark disabled" href="#"><span aria-hidden="true">←</span> Previous</a>
        <a class="btn btn-outline-primary" href="#">Next <span aria-hidden="true">→</span></a>
    </nav>

    <action-form></action-form>
</div>


