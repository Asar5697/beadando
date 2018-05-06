<?php if (!isset($_POST['reg'])) { ?>
    <form id="reg" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
        <div>
            <label for="nev">felhasznalonev</label>
            <input name="nev" id="nev">
            <div class="hidden error">Nem adtal meg felhasznalonevet</div>
        </div>

        <div>
            <label for="jelszo">jelszo</label>
            <input name="jelszo" id="jelszo" type="password">
            <div class="hidden error">Nem adtal meg jelszot</div>
        </div>

        <input name="reg" value="kuldes" type="submit">
    </form>
    <style>
        .hidden {
            display: none;
        }

        .error {
            color: #f00;
        }
    </style>
    <script>
        $("#reg").on('submit', (event) => {
            var usernameInput = $("#nev");
            var passwordInput = $("#jelszo");
            var hasError = false;

            if(usernameInput.val().length === 0) {
                usernameInput.next().removeClass("hidden");
                hasError = true;
            } else {
                usernameInput.next().addClass("hidden");
            }

            if(passwordInput.val().length === 0) {
                passwordInput.next().removeClass("hidden");
                hasError = true;
            } else {
                passwordInput.next().addClass("hidden");
            }

            if(hasError) {
                event.preventDefault();
                return false;
            }
        });
    </script>
<?php } else {
    global $credentialsManager;
    $credentialsManager->register($_POST['nev'], $_POST['jelszo']);
} ?>
