<div class="multi-select" id="<?= $id; ?>">
    <label class="control-label" for=""><?= $label; ?></label>
    <?= \yii\helpers\Html::dropDownList('', null, $list, ['class' => 'form-control list', 'id' => 'rules']); ?>
    <table class="table table-striped table-bordered table-condensed">
        <tbody>
        <tr class="hidden">
            <td></td>
            <td style="width: 30px;"><a href="#" class="remove"><i class="material-icons">delete</i> </a></td>
        </tr>
        <?php $isFirst = true; ?>
        <?php foreach($table as $dataId => $dataName): ?>
            <?php
            $class = '';
            if ($isFirst && $sortable) {
                $class = 'success';
                $isFirst = false;
            }
            ?>
            <tr data-id="<?= $dataId; ?>" class="<?= $class ?>">
                <td><?= $dataName; ?></td>
                <td style="width: 30px;"><a href="#" class="remove"><i class="material-icons">delete</i> </a></td>
                <?= \yii\helpers\Html::input('hidden', $name, $dataId) ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>