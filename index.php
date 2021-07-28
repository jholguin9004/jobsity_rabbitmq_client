<?php
require_once __DIR__ . '/vendor/autoload.php';
use Dotenv\Dotenv;
use App\Rabbit;

$dotenv = Dotenv::createImmutable(__DIR__);
$env = $dotenv->load();

$msgs = Rabbit::getMessages();
