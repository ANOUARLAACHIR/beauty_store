<?php
session_start();
session_destroy();
$errMsg .= "vous vous etes deconnécté <br>";
header("location: ../forms/login.php?errmsg=$errMsg");
