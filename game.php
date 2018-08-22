<?php

header('Content-Type: application/json');
require __DIR__.'/vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$boardWidth = 0;

if (isset($_POST['width'])) {
    $boardWidth = $_POST['width'];
}

$boardHeight = 0;

if (isset($_POST['height'])) {
    $boardHeight = $_POST['height'];
}

$randomCells = 0;
if (isset($_POST['random_cells'])) {
    $randomCells = $_POST['random_cells'];
}

$previousBoardCells = [];

if (isset($_POST['cells'])) {
    $previousBoardCells = $_POST['cells'];
}

$board = new \Classes\Board();
$board->setWidth($boardWidth);
$board->setHeight($boardHeight);

$game = new \Classes\Game();
$game->setBoard($board);
$game->setRandomCount($randomCells);
$game->setPreviousBoardCells($previousBoardCells);
$game->setRandomPositions();

$game->drawGame();

exit(json_encode($game));
