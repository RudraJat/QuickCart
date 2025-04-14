<?php
session_start();
session_destroy();
header('Location: /classproject/login.php');
exit();