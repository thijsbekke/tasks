<?php
/**
 * Created by PhpStorm.
 * User: Thijs
 * Date: 2-1-2019
 * Time: 19:12
 */

require_once "weare.php";


$auth = new AuthController();
$auth->gettoken();