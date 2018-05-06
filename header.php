<?php if (!isset($_GET['ajax'])) { ?>
    <html>
    <head>
        <script src="jquery-3.3.1.min.js"></script>
        <script>
            $(() => {
                $('li a').on('mouseenter', (event) => {
                    $(event.target).addClass('hover');
                }).on('mouseleave', (event) => {
                    $(event.target).removeClass('hover');
                });
            });
        </script>

        <style>
            .hover {
                font-size: 18;
                color: magenta;
            }
        </style>
    </head>
<body>
    <?php if ($credentialsManager->isLoggedIn()) {
        echo $credentialsManager->getLoggedInUser()['nev'] . " <a href='?logout'>logout</a>";
    } elseif (!isset($_GET['reg'])) { ?>
        <form action="index.php" method="post">
            <label for="username">username</label>
            <input name="username" id="username">
            <label for="password">password</label>
            <input name="password" id="password" type="password">
            <input type="submit">
        </form>

        <a href="?reg">regisztracio</a>
    <?php } ?>

    <ul>
        <?php

        function displayMenuEntry($entry)
        {
            if (!array_key_exists('gyerekek', $entry) || count($entry['gyerekek']) === 0) {
                return sprintf("<li><a href='index.php?page=%d'>%s</a></li>", $entry['id'], $entry['nev']);
            } else {
                $content = sprintf("<li><a href='index.php?page=%d'>%s</a>", $entry['id'], $entry['nev']);

                $subnavigation = "<ul>";
                foreach ($entry['gyerekek'] as $child) {
                    $subnavigation .= displayMenuEntry($child);
                }

                return $content . $subnavigation . "</ul></li>";
            }
        }

        foreach ($pageManager->getNavigation() as $navEntry) {
            echo displayMenuEntry($navEntry);
        }
        ?>
    </ul>
<?php } ?>