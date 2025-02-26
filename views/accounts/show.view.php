
<main class="mx-auto">
    <div class='mx-auto w-75 mx-4 py-6 px-6'>
        <h3>Email: <?= htmlspecialchars($account["email"]) ?></h3>
        <br>
        <h3>Account Status: <?=  $account["approved"] ? 'Approved': 'Pending'?></h3>
        <br>
        <h3>Account Privilege Level: <?= $account["privilege_level"]?></h3>
        <br>
        <h3>Session Privilege Level: <?= $_SESSION['user']['privilege_level']?></h3>
        <br>
    <div class="w-auto px-3">
        <a class="btn btn-primary" href="/logout">Logout</a>
        <form method="POST" action="/accounts/<?= $account['id'] ?>">
        <input type="hidden" name="_method" value="DELETE">
        <button class="btn btn-danger px-auto">Delete Account</button>
    </form>
    </div>
</main>

