<?php
include_once("Cell.php");

/**
 * Minesweeper
 *  
 * @author     Chintan Mirani
 */
class Minesweeper {

	/** @var Rows  */
    private $rows;

    /** @var Columns  */
    private $cols;

    /** @var Board  */
    public $board = array();

    /** @var Board Visited */
    public $boardVisited = array();

    /**
     * Ganarate all empty boxes and place the bomb
     * @param integer $rows  number of rows
     * @param integer $cols  number of columns
     * @param integer $bombs number of bombs
     */
    public function __construct(int $rows, int $cols, int $bombs) {
        $this->rows = $rows;
        $this->cols = $cols;

        // Create blank array
        for ($i = 1; $i <= $rows; $i++) {
            for ($j = 1; $j <= $cols; $j++) {
                $this->board[$i][$j] = new Cell($i, $j);
            }
        }

        // Set bombs in a array
        for ($i = 1; $i <= $bombs; $i++) {
            $rendRow = rand(1, $rows);
            $rendCol = rand(1, $cols);
            ($this->board[$rendRow][$rendCol]->value == -1) ? $i-- : $this->board[$rendRow][$rendCol]->value = -1;
        }

        // Set default visited false 
        for ($i = 1; $i <= $rows ; $i++) { 
            for ($j = 1; $j <= $cols ; $j++) { 
                $this->boardVisited[$i][$j] = false;
            }
        }
    }

    /**
     * Check winning
     * @return integer flag
     */
    public function haveWin() {
        $flag = 1;
        for ($i = 1; $i <= $this->rows ; $i++) { 
            for ($j = 1; $j<=$this->cols ; $j++) { 
                if (!$this->board[$i][$j]->visible && $this->board[$i][$j]->value != -1) {
                    $flag = 0;
                } 
            }
        }
        return $flag;
    }

    /**
     * Print game table in terminal
     * 
     */
    public function printRowCol() {
        echo "\n";
        for ($i = 1; $i <= $this->rows ; $i++) { 
            for ($j = 1; $j <= $this->cols ; $j++) { 
                if ($this->boardVisited[$i][$j]) {
                	if ($this->board[$i][$j]->value == -1) {
						echo " \u{1F4A3}";
	                } else {
                    	echo " ".$this->board[$i][$j]->value." ";
	                }
                } else {
					echo " * ";
                }
            }
            echo("\n");
        }
        echo("\n");
    }

    /**
     * Set call values according to bomb call 
     * @param  integer $row number of rows
     * @param  integer $col number of columns
     * @return integer      bomb 
     */
    public function haveAdjacent(int $row, int $col) {
        if ($row > 0 && $row <= $this->rows && $col > 0 && $col <= $this->cols && !$this->boardVisited[$row][$col]) {
            $this->boardVisited[$row][$col] = true;
            $bombs = 0;

            if (isset($this->board[$row-1][$col]) && $this->board[$row-1][$col]->value == -1) {
                $bombs++;
            }

            if (isset($this->board[$row-1][$col+1]) && $this->board[$row-1][$col+1]->value == -1) {
                $bombs++;
            }

            if (isset($this->board[$row][$col+1]) && $this->board[$row][$col+1]->value == -1) {
                $bombs++;
            }

            if (isset($this->board[$row+1][$col+1]) && $this->board[$row+1][$col+1]->value == -1) {
                $bombs++;
            }

            if (isset($this->board[$row+1][$col]) && $this->board[$row+1][$col]->value == -1) {
                $bombs++;
            }

            if (isset($this->board[$row+1][$col-1]) && $this->board[$row+1][$col-1]->value == -1) {
                $bombs++;
            }

            if (isset($this->board[$row][$col-1]) && $this->board[$row][$col-1]->value == -1) {
                $bombs++;
            }

            if (isset($this->board[$row-1][$col-1]) && $this->board[$row-1][$col-1]->value == -1) {
                $bombs++;
            }

            if (!$bombs) {
                $this->haveAdjacent($row-1, $col);
                $this->haveAdjacent($row, $col+1);
                $this->haveAdjacent($row+1, $col);
                $this->haveAdjacent($row, $col-1);
            }

            $this->board[$row][$col]->visible = true;
            $this->board[$row][$col]->value = $bombs;

            return $bombs;
        }
    }
}

?>
