<?php Block::put('breadcrumb') ?>
    <ul>
        <li><a href="<?= Backend::url('overlander/transaction/pointhistory') ?>">PointHistory</a></li>
        <li><?= e($this->pageTitle) ?></li>
    </ul>
<?php Block::endPut() ?>

<?php if (!$this->fatalError): ?>

    <div class="form-preview">
        <?= $this->formRenderPreview() ?>
    </div>

<?php else: ?>
    <p class="flash-message static error"><?= e($this->fatalError) ?></p>
<?php endif ?>

<p>
    <a href="<?= Backend::url('overlander/transaction/pointhistory') ?>" class="btn btn-default oc-icon-chevron-left">
        <?= e(trans('backend::lang.form.return_to_list')) ?>
    </a>
    <a href="<?= Backend::url('overlander/transaction/transaction') ?>" class="btn btn-default oc-icon-chevron-left">
        <?= e(trans('overlander.transaction::lang.list.btn_return')) ?>
    </a>
</p>
