<?php
session_start();
($_SESSION['staging']==0?$_SESSION['staging']=1:$_SESSION['staging']=0);
//var_dump($_SESSION);
?>