<?php

class PageManager
{
    /** @var mysqli */
    private $mysqli;

    public function __construct(mysqli $mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function getNavigation()
    {
        $result = $this->mysqli->query("SELECT * FROM menu ORDER BY szulo ASC;");

        $navigation = [];

        $entries = $result->fetch_all(MYSQLI_ASSOC);

        if ($entries === NULL) {
            return [];
        }

        foreach ($entries as $entry) {
            if ($entry['szulo'] === NULL) {
                $navigation[$entry['id']] = [
                    'id' => $entry['id'],
                    'nev' => $entry['nev'],
                    'gyerekek' => []
                ];
            } else {
                $navigation[$entry['szulo']]['gyerekek'][] = [
                    'id' => $entry['id'],
                    'nev' => $entry['nev']
                ];
            }
        }

        return $navigation;
    }

    public function getPage($navId)
    {
        $stmt = $this->mysqli->prepare("SELECT * FROM menu WHERE id = ? LIMIT 1;");
        $stmt->bind_param("d", $navId);
        $stmt->execute();

        if ($stmt->affected_rows === 0) {
            return false;
        }

        $navEntry = $stmt->get_result()->fetch_array(MYSQLI_ASSOC);

        if ($navEntry['oldal'] !== NULL) {
            echo $this->getPageEntry($navEntry['oldal']);
        } else {
            require_once $navEntry['script'];
        }
    }

    public function getPageEntry($pageId)
    {
        $stmt = $this->mysqli->prepare("SELECT * FROM oldalak WHERE id = ? LIMIT 1;");
        $stmt->bind_param("d", $pageId);
        $stmt->execute();

        if ($stmt->affected_rows === 0) {
            return false;
        }

        echo $stmt->get_result()->fetch_array(MYSQLI_ASSOC)['tartalom'];
    }
}