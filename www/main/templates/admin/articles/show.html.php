<?php $view->extend('admin/_layout.html.php') ?>

<?php $view['slots']->set('title', 'Dashboard') ?>

<?php $view['slots']->set('action-header', 'Update article') ?>

<div class="articles-list">
    <?php if ($errors) : ?>
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0">
                <?php foreach ($errors->firstOfAll() as $error) : ?>
                    <li><?= $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="/article/<?= $article->id ?>/store" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Title</label>
            <input
                type="text"
                name="title"
                class="form-control"
                placeholder="Enter title here..."
                value="<?= $article->title; ?>"
            >
        </div>
        <div class="form-group">
            <label for="topic_id">Topic</label>
            <select class="form-control" name="topic_id">
                <option value="">Choose topic...</option>
                <?php foreach ($topics as $topic) : ?>
                    <option value="<?= $topic['id']; ?>" <?= ($topic['id'] === $article->topic_id) ? "selected" : ""; ?>><?= $topic['title']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="author_id">Author</label>
            <select class="form-control" name="author_id">
                <option value="">Choose author...</option>
                <?php foreach ($authors as $author) : ?>
                    <option value="<?= $author['id']; ?>" <?= ($author['id'] === $article->author_id) ? "selected" : ""; ?>><?= $author['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea
                name="description"
                class="form-control"
                rows="3"
                maxlength="192"
            ><?= $article->description; ?></textarea>
        </div>
        <div class="form-group">
            <label for="body">Content</label>
            <textarea
                name="body"
                class="form-control"
                rows="7"
            ><?= $article->body; ?></textarea>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" class="form-control-file">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <button
            type="button"
            class="btn btn-outline-dark"
            onclick="window.history.back();"
        >
            Cancel
        </button>
    </form>

    <action-form></action-form>
</div>