<?php

global $mysqli;
global $credentialsManager;

require_once 'guestbook-manager.php';

$newsManager = new GuestbookManager($mysqli);

if (isset($_POST['post'])) {
    $newsManager->postResponse($_POST['szoveg']);
}

if (isset($_GET['ajax'])) {
    foreach ($newsManager->getContents() as $entry) { ?>
        <table border="1">
            <tr>
                <td><?php echo $entry['nev'] ?></td>
                <td><?php echo $entry['time'] ?></td>
            </tr>
            <tr>
                <td colspan="2"><?php echo $entry['szoveg'] ?></td>
            </tr>
        </table>
    <?php }
} else {
    if ($credentialsManager->isLoggedIn()) { ?>
        <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
            <label for="szoveg">szoveg</label>
            <input name="szoveg" id="szoveg">

            <input name="post" value="kuldes" type="submit">
        </form>
    <?php } ?>

    <div id="hozzaszolasok"></div>
    <script>
        $.get({
            url: "<?php echo $_SERVER['REQUEST_URI'] ?>&ajax",
            success: (response) => {
                $("#hozzaszolasok").html(response);
            }
        });
    </script>
<?php } ?>