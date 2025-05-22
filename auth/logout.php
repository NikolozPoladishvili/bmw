<?php
session_start();
session_destroy();
header("Location: /bmw/index.php");
exit;