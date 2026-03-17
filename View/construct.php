<?php
    if (!isset($_GET['table'])) {
        echo "<h2>Выберите таблицу</h2>";
        return;
    }
    $structure = [];
    if(isset($columns)){
        $structure = $columns;
    }
    $currentTable = $_GET['table'];
?>

<header class="bo-header">
    <h1>Конструктор структуры: <?= htmlspecialchars($currentTable) ?></h1>
</header>

<section class="bo-table-section" style="width: fit-content;">
    <table class="bo-table" data-mode="construct">
        <thead>
            <tr>
                <th>Название столбца</th>
                <th>NULL</th>
                <th>Автоинкремент</th>
                <th class="bo-actions-column">Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($structure as $colName => $settings): ?>
                <tr>
                    <td>
                        <input type="text" 
                               value="<?= htmlspecialchars($colName) ?>" 
                               class="bo-input ajax-input" 
                               name="Field" 
                               data-id="<?= htmlspecialchars($colName) ?>" 
                               data-table="<?= htmlspecialchars($currentTable) ?>"
                               <?= ($colName === 'id') ? 'readonly' : '' ?>>
                    </td>
                    <td style="text-align: center;">
                        <input type="checkbox" 
                               class="bo-checkbox ajax-input" 
                               name="is_null" 
                               data-id="<?= htmlspecialchars($colName) ?>" 
                               data-table="<?= htmlspecialchars($currentTable) ?>"
                               <?= ($settings['required'] !== 'required') ? 'checked' : '' ?>>
                    </td>
                    <td style="text-align: center;">
                        <input type="checkbox" 
                               class="bo-checkbox ajax-input" 
                               name="is_ai" 
                               data-id="<?= htmlspecialchars($colName) ?>" 
                               data-table="<?= htmlspecialchars($currentTable) ?>"
                               <?= ($settings['disabled'] === 'disabled') ? 'checked' : '' ?>>
                    </td>
                    <td>
                        <?php if ($colName !== 'id'): ?>
                            <button class="bo-btn-delete ajax-delete" 
                                    data-id="<?= htmlspecialchars($colName) ?>" 
                                    data-table="<?= htmlspecialchars($currentTable) ?>">DROP</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>

            <tr class="new-column-row">
                <td>
                    <input type="text" class="bo-input ajax-empty" name="Field" data-table="<?= htmlspecialchars($currentTable) ?>" placeholder="Новое поле...">
                </td>
                <td style="text-align: center;">
                    <input type="checkbox" class="bo-checkbox ajax-empty" name="is_null">
                </td>
                <td style="text-align: center;">
                    <input type="checkbox" class="bo-checkbox ajax-empty" name="is_ai">
                </td>
                <td></td>
            </tr>
        </tbody>
    </table>
</section>