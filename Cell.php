<?php 

/**
 * Cell
 * 
 * @author     Chintan Mirani
 */
class Cell {

    /** @var Rows */
    private $row;

    /** @var Columns */
    private $col;

    /** @var Call values */
    public $value;

    /** @var Call vasible */
    public $visible;

    /**
     * Set empty values
     * @param integer $row number of row
     * @param integer $col number of column
     */
    public function __construct(int $row, int $col) {
        $this->row = $row;
        $this->col = $col;
        $this->value = 0;
        $this->visible = false;
    }
}

?>
