<?php
session_start();
session_unset();
session_destroy();
header("Location: /bmw/index.php");
exit;