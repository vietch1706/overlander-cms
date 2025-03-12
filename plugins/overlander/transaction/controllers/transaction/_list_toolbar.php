<div data-control="toolbar">
    <button
        class="btn btn-default oc-icon-trash-o"
        data-request="onDelete"
        data-request-confirm="<?= e(trans('backend::lang.list.delete_selected_confirm')) ?>"
        data-list-checked-trigger
        data-list-checked-request
        data-stripe-load-indicator>
        <?= e(trans('backend::lang.list.delete_selected')) ?>
    </button>
    <a
        href="<?= Backend::url('overlander/transaction/transaction/import') ?>"
        class="btn btn-default oc-icon-upload">
        Import
    </a>
</div>
