<?php

class NewsManager
{
    /** @var mysqli */
    private $mysqli;

    public function __construct(mysqli $mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function getNews() {
        $result = $this->mysqli->query("SELECT * FROM hir LEFT JOIN user ON hir.user = user.id ORDER BY time DESC");

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function postArticle($cim, $tartalom) {
        global $credentialsManager;

//        if(!$credentialsManager->isLoggedIn()) {
//            return;
//        }

        $stmt = $this->mysqli->prepare("INSERT INTO hir (`user`, `time`, `cim`, `tartalom`) VALUES (?, CURRENT_TIMESTAMP(), ?, ?);");
        $stmt->bind_param("dss", $credentialsManager->getLoggedInUser()['id'], $cim, $tartalom);
        $stmt->execute();
    }
}