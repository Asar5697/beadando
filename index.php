<?php 

require_once 'init.php';

if(isset($_GET['reg'])) {
  require_once 'reg.php';
} elseif(isset($_GET['page'])) {
    $pageManager->getPage($_GET['page']);
}