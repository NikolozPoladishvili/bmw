<?php
session_start();
session_destroy();
header("Location: /bmw-project/index.php");
exit;