<?php
require_once __DIR__ . '/vendor/autoload.php';
use Dotenv\Dotenv;
use App\Rabbit;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$msgs = Rabbit::getMessages();