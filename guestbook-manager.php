<?php

class GuestbookManager
{
    /** @var mysqli */
    private $mysqli;

    public function __construct(mysqli $mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function getContents() {
        $result = $this->mysqli->query("SELECT * FROM hozzaszolas LEFT JOIN user ON hozzaszolas.user = user.id ORDER BY time DESC");

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function postResponse($szoveg) {
        global $credentialsManager;

        if(!$credentialsManager->isLoggedIn()) {
            return;
        }

        $stmt = $this->mysqli->prepare("INSERT INTO hozzaszolas (`user`, `szoveg`, `time`) VALUES (?, ?, CURRENT_TIMESTAMP());");

        var_dump($this->mysqli->error);
        $stmt->bind_param("ds", $credentialsManager->getLoggedInUser()['id'], $szoveg);
        $stmt->execute();
    }
}