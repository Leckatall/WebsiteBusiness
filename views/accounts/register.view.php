<main>
    <div class='card p-3 m-3 w-25 mx-auto'>
        <form class="form-group " action="/accounts" method="POST">
            <div class="-space-y-px rounded-md shadow-sm">

                <div>
                    <label for="email" class="sr-only">Email address</label>
                    <input id="email" name="email" type="email" autocomplete="email" required
                           class="form-control mb-3"
                           placeholder="Email address">
                    <?php if (isset($errors['email'])) : ?>
                        <p class="text-red-500 text-xs mt-2"><?= $errors['email'] ?></p>
                    <?php endif; ?>
                </div>


                <div>
                    <label for="password" class="sr-only">Password</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                           class="form-control mb-3"
                           placeholder="Password">
                    <?php if (isset($errors['password'])) : ?>
                        <p class="text-red-500 text-xs mt-2"><?= $errors['password'] ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="rounded-md shadow-sm">
                <label for="privilegeLevel" class="form-label">Account Type:</label>
                <select class="form-control form-select" name="privilegeLevel" id="privilegeLevel">
                    <option value=1>Student</option>
                    <option value=2>Tutor</option>
                    <option value=3>Admin</option>
                </select>
            </div>
            <div class="mx-2 my-2 py-2">
                <button type="submit"
                        class="btn btn-primary form-control px-2">
                    Register
                </button>
            </div>

        </form>
    </div>
</main>
