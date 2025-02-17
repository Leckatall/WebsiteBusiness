<!-- The Modal -->
<div id="login_widget" class="modal" style="display: none">
  <span onclick="document.getElementById('login_widget').style.display='none'"
        class="close" title="Close Modal">&times;</span>

    <!-- Modal Content -->
    <form class="modal-content animate" action="/login_view.php">
        <div class="imgcontainer">
            <img src="" alt="Avatar" class="avatar">
        </div>

        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Login</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>



        <div class="container">
            <label for="uname"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="uname" required>

            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="psw" required>

            <button type="submit">Login</button>
            <label>
                <input type="checkbox" checked="checked" name="remember"> Remember me
            </label>
        </div>

        <div class="container" style="background-color:#f1f1f1">
            <button type="button" onclick="document.getElementById('login_widget').style.display='none'" class="cancelbtn">
                Cancel
            </button>
        </div>
    </form>
</div>

<link rel="stylesheet" href=
"https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<script src=
        "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js">
</script>

<script src=
        "https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js">
</script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<div id="login" class="dropdown" aria-haspopup="true">
    <p class="user actions">
        <a id="login-dropdown" href="/users/login.php" class="dropdown-toggle" data-toggle="dropdown" data-target="#">Log In</a>
    </p>
    <div id="small_login" class="simple login">
        <form class="new_user" id="new_user_session_small" action="/users/login.php" accept-charset="UTF-8" method="post">
<!--            <input type="hidden" name="authenticity_token" value="s9RX3ROlzs0XmfKL_fR_Z7XR3tOqo9ftVnUGm2uztSO89DFLC03QRmr1c0eHw72vcGCbZGN4Wsii7XU2Thw4Qw" autocomplete="off">-->
            <dl>
                <dt><label for="user_session_login_small">User name or email:</label></dt>
                <dd><input id="user_session_login_small" type="text" name="user[login]"></dd>

                <dt><label for="user_session_password_small">Password:</label></dt>
                <dd><input id="user_session_password_small" type="password" name="user[password]"></dd>
            </dl>
            <p class="submit actions">
                <label for="user_remember_me_small" class="action">
                    <input type="checkbox" name="user[remember_me]" id="user_remember_me_small" value="1">Remember Me
                </label>
                <input type="submit" name="commit" value="Log In">
            </p>
        </form>
        <ul class="footnote actions">
            <li><a href="/users/password/new">Forgot password?</a></li>
            <li>
                <a href="/signup">Sign up</a>
            </li>
        </ul>
    </div>
</div>