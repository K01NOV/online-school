<header class="bo-header">
    <h1>Редактирование таблицы: Users</h1>
</header>
<section class="bo-table-section">
    <table class="bo-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Email</th>
                <th>Роль</th>
                <th class="bo-actions-column">Действие</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td><input type="text" value="Иван Иванов" class="bo-input"></td>
                <td><input type="email" value="ivan@example.com" class="bo-input"></td>
                <td>
                    <select class="bo-input">
                        <option>Admin</option>
                        <option selected>Student</option>
                    </select>
                </td>
                <td>
                    <button class="bo-btn-delete">DELETE</button>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td><input type="text" value="Петр Петров" class="bo-input"></td>
                <td><input type="email" value="petr@example.com" class="bo-input"></td>
                <td><select class="bo-input"><option>Admin</option></select></td>
                <td><button class="bo-btn-delete">DELETE</button></td>
            </tr>
        </tbody>
    </table>
</section>