<?php

include_once("Minesweeper.php");
session_start();
system('clear');

// Get number of rows
do {
    $rows = (int) readline('Enter number of rows : ');
} while (!$rows);

// Get number of columns
do {
    $cols = (int) readline('Enter number of colums : ');
} while (!$cols);

// Total calls
$cells = $rows * $cols;

// Get number of bomb in game
$bombs = (int) readline('Enter number of bombs (Less then : '.($cells).') : ');

// Check bomb number not a more then calls numbers
while ($bombs >= ($cells)) {
    system('clear');
    echo "Bombs number must be less than ".($cells)."\n";
    $bombs = (int)readline('Enter number of bombs : ');
}

$minesweeper = new Minesweeper($rows, $cols, $bombs);

$start = false;
system('clear');

// Game start
echo("Good luck! Game started...\n");

// Print rows and columns
$minesweeper->printRowCol();

// Start playing game
do {
    if ($start) {
        system('clear');
        echo "Great! There is no bumb\n\n";
        $minesweeper->printRowCol();
    }

    // Get open cell row number
    $checkRow = (int)readline('Enter row number : ');
    while ($checkRow > $rows) {
        system('clear');
        echo "Row must be less than or equal to ".$rows."\n";
        $checkRow = (int)readline('Enter row number : ');
    }

    // Get open cell column number
    $checkCol = (int)readline('Enter column number : ');
    while ($checkCol > $cols) {
        system('clear');
        echo "Column must be less than or equal to ".$cols."\n";
        echo "Entered Row : ".$rows."\n";
        $checkCol = (int)readline('Enter column number : ');
    }

    // Cell opening
    if ($minesweeper->boardVisited[$checkRow][$checkCol]) {
        system('clear');
        echo "Already open\n";
        $minesweeper->printRowCol();
        echo "Choose another call\n";
        sleep(1);
    } else {
        if ($minesweeper->board[$checkRow][$checkCol]->value == -1) {
            for ($i = 1; $i <= $rows; $i++) {
                for ($j = 1; $j <= $cols; $j++) {
                    if ($minesweeper->board[$i][$j]->value == -1) {
                        $minesweeper->boardVisited[$i][$j] = true;
                    }
                }
            }
            system('clear');
            $minesweeper->printRowCol();
            echo "You lose| Better luck next time!\n";
            break;
        }

        $minesweeper->haveAdjacent($checkRow, $checkCol);

        if ($minesweeper->haveWin()) {
            system('clear');
            $minesweeper->printRowCol();
            echo "Congratulations! You win!\n";
            break;
        }
    }
    $start = true;
} while ($minesweeper->board[$checkRow][$checkCol]->value != -1);

echo "Game over!\n\n";

?>
