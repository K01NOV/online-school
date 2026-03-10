<header class="bo-header">
    <h1>Редактирование таблицы<? if(isset($_GET['table'])) echo ": " . htmlspecialchars($_GET['table'])?></h1>
</header>
<? if(isset($_GET['table'])):?>
    <section class="bo-table-section">
        <table class="bo-table">
    <thead>
        <tr>
            <?php foreach($columns as $colName => $settings): ?>
                <th><?= htmlspecialchars($colName) ?></th>
            <?php endforeach; ?>
            <th class="bo-actions-column">Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($data as $row): ?>
            <tr>
                <?php foreach($columns as $colName => $settings): ?>
                    <td>
                        <?php 
                        $value = $row[$colName] ?? ""; // Достаем значение именно этой колонки из строки БД
                        
                        // Если это ID просто выводим текст (редактировать нельзя)
                        if ($colName === 'id' || $settings['disabled'] === 'disabled'): ?>
                            <span><?= htmlspecialchars($value) ?></span>
                            <input type="hidden" name="<?= $colName ?>[]" value="<?= htmlspecialchars($value) ?>">
                        
                        <?php else: ?>
                            <input 
                                type="<?= $settings['type'] ?>" 
                                value="<?= htmlspecialchars($value) ?>" 
                                class="bo-input ajax-input"
                                name="<?= htmlspecialchars($colName)?>"
                                data-id="<?= htmlspecialchars($row['id'])?>"
                                data-table="<? if(isset($_GET['table'])) echo htmlspecialchars($_GET['table'])?>"
                                <?= $settings['required'] ?>
                            >
                        <?php endif; ?>
                    </td>
                <?php endforeach; ?>

                <td>
                    <button 
                        class="bo-btn-delete ajax-delete" 
                        data-id="<?= htmlspecialchars($row['id'])?>" 
                        data-table="<? if(isset($_GET['table'])) echo htmlspecialchars($_GET['table'])?>"
                        >DELETE
                    </button>
                </td>
            </tr>
        <?php endforeach;?>
            <tr>
                <?php foreach($columns as $colName => $settings):?>
                    <td>
                        <?php if ($colName === 'id' || $settings['disabled'] === 'disabled'): ?>
                            <span>
                                <?php if(!empty($data)){
                                    $id = $data[count($data) - 1]['id'] + 1;
                                } else{
                                    $id = 1;
                                }
                                echo htmlspecialchars($id);?>
                            </span>
                            <input type="hidden" name="<?= $colName ?>[]" value="<?= htmlspecialchars($value) ?>">
                        
                        <?php else: ?>
                            <input 
                                type="<?= $settings['type'] ?>" 
                                value="" 
                                class="bo-input ajax-empty"
                                name="<?= htmlspecialchars($colName)?>"
                                data-table="<? if(isset($_GET['table'])) echo htmlspecialchars($_GET['table'])?>"
                                <?= $settings['required'] ?>
                            >
                        <?php endif; ?>
                    </td>
                <?php endforeach?>
            </tr>
    </tbody>
</table>
    </section>
<?php endif?>
