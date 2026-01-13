<?php

// Memaksa PHP untuk tidak menampilkan peringatan deprecated
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
ini_set('display_errors', '0');

require __DIR__ . '/../public/index.php';