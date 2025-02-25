
<main>
    <div class='card p-3 m-3 w-25 mx-auto'>
        <form class="form-group " action="/login" method="POST">
            <div class="-space-y-px rounded-md shadow-sm">

                <div>
                    <label for="email" class="sr-only">Email address</label>
                    <input id="email" name="email" type="email" autocomplete="email" required
                           class="form-control mb-3"
                           placeholder="Email address">
                </div>

                <div>
                    <label for="password" class="sr-only">Password</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                           class="form-control mb-3"
                           placeholder="Password">
                </div>
            </div>

            <div>
                <button type="submit"
                        class="btn btn-primary form-control px-2">
                    Log In
                </button>
            </div>

            <ul>
                <?php if ($error) : ?>
                    <li class="text-red-500 text-xs mt-2"><?= $error ?></li>
                <?php endif; ?>

            </ul>
        </form>
        <a href="/register">No Account? Register here</a>
    </div>
</main>


