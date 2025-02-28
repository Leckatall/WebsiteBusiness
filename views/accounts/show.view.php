
<main class="mx-auto">
    <div class='card m-5'>
        <div class="card-header text-center">
            <h3><?= htmlspecialchars($account["email"]) ?></h3>
        </div>
        <div class="card-body">
            <h3>Account Status: <?= $account["approved"] ? 'Approved' : 'Pending' ?></h3>
            <h3>Role: <?= ["NULL/ERR", "Student", "Tutor", "Admin"][$account["privilege_level"]] ?></h3>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <form method="POST" action="/accounts/<?= $account['id'] ?>">
                <input type="hidden" name="_method" value="DELETE">
                <button class="btn btn-danger px-auto">Delete Account</button>
            </form>
            <a class="btn btn-primary w-25" href="/logout">Logout</a>
        </div>
</main>

