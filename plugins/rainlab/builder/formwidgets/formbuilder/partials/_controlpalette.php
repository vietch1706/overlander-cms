<div class="control-scrollpad" data-control="scrollpad">
    <div class="scroll-wrapper">

        <div class="control-filelist filelist-hero" data-control="filelist">
            <ul>
                <?php foreach ($controlGroups as $index=>$group): ?>
                    <li class="separator">
                        <h5><?=  e($group) ?></h5>
                    </li>

                    <?php foreach ($registeredControls[$group] as $controlCode=>$controlInfo): ?>
                        <li>
                            <a href="javascript:;"
                                data-builder-control-palette-control="<?= e($controlCode) ?>"
                                data-builder-control-type="<?= e($controlCode) ?>"
                                data-builder-control-name="<?= e(trans($controlInfo['name'])) ?>"
                                data-builder-command="modelForm:cmdAddControl"
                            >
                                <i class="list-icon <?= isset($controlInfo['icon']) ? e($controlInfo['icon']) : 'icon-square-o' ?>"></i>
                                <span class="title"><?= e(trans($controlInfo['name'])) ?></span>
                                <span class="description">
                                    <?= e(trans($controlInfo['description'])) ?>
                                </span>
                                <span class="borders"></span>
                            </a>
                        </li>
                    <?php endforeach ?>
                <?php endforeach ?>
            </ul>
        </div>

    </div>
</div>