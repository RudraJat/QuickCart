<?php
session_start();
session_destroy();
header('Location: /Rudra/ecommerce/index.php');
exit();