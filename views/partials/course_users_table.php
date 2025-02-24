<?php const ROLES = ['NONE/ERR', 'Student', 'Tutor', 'Admin'] ?>

<table>
    <thead>
    <tr>
        <th>Email</th>
        <th>Role</th>
        <th>Score</th>
        <th>Status</th>
        <th>Approve</th>
        <th>Remove</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($accounts as $account): ?>
        <tr>
            <td><a href="/account?id=<?= $account['id'] ?>"><?= htmlspecialchars($account['email']) ?></a></td>
            <td><?= ROLES[$account['privilege_level']] ?></td>
            <td><?= $account['score'] ?></td>
            <td><?= $account['approved'] ? 'Approved' : 'Pending'; ?></td>
            <td>
                <?php if (!$account['approved']): ?>
                    <form method="POST" action="/course/users">
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="action" value="approve">
                        <input type="hidden" name="account_id" value="<?= $account['id']; ?>">
                        <button type="submit">Approve</button>
                    </form>
                <?php else: ?>
                    <span>Already Approved</span>
                <?php endif; ?>
            </td>
            <td>
                <form method="POST" action="/course/users">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="account_id" value="<?= $account['id']; ?>">
                    <button type="submit">Remove</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>


