
<main>
    <div class='mx-auto max-w-7xl py-6 sm:px-6 lg:px-8'>
        <h1>The Account Page for <?= htmlspecialchars($account["Email"]) ?></h1>
    </div>
    <div>
        <h3>Account Status: <?= $status?></h3>
    </div>
    <div>
        <h3>Account Privilege Level: <?= $account["PrivilegeLvl"]?></h3>
    </div>

    <div>
        <h3>Session Privilege Level: <?= $_SESSION["privilege_level"]?></h3>
    </div>

    <div>
        <a href="/logout">Logout</a>
    </div>

    <form method="POST">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="id" value="<?= $account['Id'] ?>">
        <button class="text-sm text-red-500">DELETE ACCOUNT</button>
    </form>
</main>

