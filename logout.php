<?php
session_start();

session_destroy();

header("Location: formulaire_crea_post.php");

