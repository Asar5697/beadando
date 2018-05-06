<?php

global $mysqli;
global $credentialsManager;

require_once 'news-manager.php';

$newsManager = new NewsManager($mysqli);

if (isset($_POST['post'])) {
    $newsManager->postArticle($_POST['cim'], $_POST['tartalom']);
}

if (isset($_GET['ajax'])) {
    foreach ($newsManager->getNews() as $entry) { ?>
        <table border="1">
            <tr>
                <td><?php echo $entry['cim'] ?></td>
                <td><?php echo $entry['nev'] ?></td>
                <td><?php echo $entry['time'] ?></td>
            </tr>
            <tr>
                <td colspan="3"><?php echo $entry['tartalom'] ?></td>
            </tr>
        </table>
    <?php }
} else {
    if ($credentialsManager->isLoggedIn()) { ?>
        <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
            <label for="cim">cim</label>
            <input name="cim" id="cim">

            <label for="tartalom">tartalom</label>
            <input name="tartalom" id="tartalom">

            <input name="post" value="kuldes" type="submit">
        </form>
    <?php } ?>

    <div id="hirek"></div>
    <script>
        $.get({
            url: "<?php echo $_SERVER['REQUEST_URI'] ?>&ajax",
            success: (response) => {
                $("#hirek").html(response);
            }
        });
    </script>
<?php } ?>