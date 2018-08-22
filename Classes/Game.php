<?php

namespace Classes;

class Game
{
    /**
     * @var
     * Cells object
     */
    public $cells;

    /**
     * @var
     * Board object
     */
    public $board;

    /**
     * @var int
     * Current cell position in the board
     */
    private $currentPosition = 0;

    /**
     * @var int
     * Random live cells count
     */
    public $randomCount = 0;

    /**
     * @var array
     */
    private $randomPositions = [];

    /**
     * @var array
     * Previous board cells
     */
    private $previousBoardCells = [];

    const alive = 1;

    const dead = 0;

    public function drawGame()
    {
        $this->cells = $this->drawNextButton();

        $this->cells .= '<table class="table-bordered text-center">';

        for ($row = 0; $row < $this->board->width; $row++) {
            $this->cells .= '<tr>';

            for ($col = 0; $col < $this->board->height; $col++) {

                switch($this->randomCount)
                {
                    case 0:
                        $this->cells .= $this->drawCell($row, $col);
                        break;
                    default:
                        $this->cells .= $this->drawRandomCell($row, $col);
                        break;
                }

                $this->currentPosition++;
            }

            $this->cells .= '</tr>';
        }

        $this->cells .= '</table>';

    }

    private function drawRandomCell($row, $col)
    {
        $cell = '';

        if (in_array($this->currentPosition, $this->randomPositions)) {
            $cell .= $this->drawActiveCell($row, $col);
        }
        else {
            $cell .= $this->drawInactiveCell($row, $col);
        }

        return $cell;
    }

    private function drawCell($row, $col)
    {
        $cellStatus = $this->previousBoardCells[$row][$col] ?? 0;
        $aliveNeighbours = $this->getAliveNeighboursCount($row, $col);

        if ($cellStatus == self::alive && $aliveNeighbours < 2)
        {
            return $this->drawInactiveCell($row, $col);
        }

        if ($cellStatus == self::alive && in_array($aliveNeighbours, [2,3]))
        {
            return $this->drawActiveCell($row, $col);
        }

        if ($cellStatus == self::alive && $aliveNeighbours > 3)
        {
            return $this->drawInactiveCell($row, $col);
        }

        if ($cellStatus == self::dead && $aliveNeighbours === 3)
        {
            return $this->drawActiveCell($row, $col);
        }

        return $this->drawInactiveCell($row, $col);
    }

    private function getAliveNeighboursCount($row, $col)
    {
        $neighbours = [
            $this->previousBoardCells[$row][$col - 1] ?? 0,
            $this->previousBoardCells[$row][$col + 1] ?? 0,
            $this->previousBoardCells[$row - 1][$col - 1] ?? 0,
            $this->previousBoardCells[$row - 1][$col + 1] ?? 0,
            $this->previousBoardCells[$row - 1][$col] ?? 0,
            $this->previousBoardCells[$row + 1][$col + 1] ?? 0,
            $this->previousBoardCells[$row + 1][$col - 1] ?? 0,
            $this->previousBoardCells[$row + 1][$col] ?? 0,
        ];

        $neighbours = array_count_values($neighbours);
        $aliveNeighbours = 0;

        if (isset($neighbours[self::alive])) {
            $aliveNeighbours = $neighbours[self::alive];
        }

        return $aliveNeighbours;
    }

    public function setBoard(Board $board)
    {
        $this->board = $board;
    }

    public function setRandomCount($randomCount = 0)
    {
        $this->randomCount = $randomCount;
    }

    public function setPreviousBoardCells($previousBoardCells)
    {
        $this->previousBoardCells = $previousBoardCells;

    }

    public function setRandomPositions()
    {
        if ($this->randomCount > 0) {
            $maxNumber = ($this->board->width * $this->board->height) - 1;
            $this->randomPositions = $this->setRandomPositionsRecursion($this->randomCount, $maxNumber);
        }
    }

    private function setRandomPositionsRecursion($count, $maxNumber, $randomPositions = [])
    {
        if (count($randomPositions) == $count) {
            return $randomPositions;
        }

        $minNumber = 0;

        $randomNumber = rand($minNumber, $maxNumber);

        if(! in_array($randomNumber, $randomPositions))
        {
            array_push($randomPositions, $randomNumber);
        }

        return $this->setRandomPositionsRecursion($count, $maxNumber, $randomPositions);
    }

    private function drawActiveCell($row, $col)
    {
        return '<td class="active-cell" bgcolor="#000">&nbsp;
                    <input type="hidden" name="cells['.$row.']['.$col.']" value="1">
                </td>';
    }

    private function drawInactiveCell($row, $col)
    {
        return '<td class="inactive-cell" bgcolor="#fff">&nbsp;
                    <input type="hidden" name="cells['.$row.']['.$col.']" value="0">
                </td>';
    }

    private function drawNextButton()
    {
        return '<button type="submit" class="btn btn-primary">
            Next <i class="glyphicon glyphicon-chevron-right"></i>
        </button>';
    }
}
