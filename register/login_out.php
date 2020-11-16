<?php
session_start();
require 'functions.php';

unset($_SESSION['login']);
redirect_to('page_login.php');