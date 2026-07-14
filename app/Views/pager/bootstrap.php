<?php if ($pager->getPageCount() > 1): ?>

<nav>
    <ul class="pagination justify-content-center">

        <?php if ($pager->hasPrevious()): ?>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getPreviousPageURI() ?>">
                    &laquo;
                </a>
            </li>
        <?php endif; ?>

        <?php foreach ($pager->links() as $link): ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a class="page-link" href="<?= $link['uri'] ?>">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach; ?>

        <?php if ($pager->hasNext()): ?>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getNextPageURI() ?>">
                    &raquo;
                </a>
            </li>
        <?php endif; ?>

    </ul>
</nav>

<?php endif; ?>