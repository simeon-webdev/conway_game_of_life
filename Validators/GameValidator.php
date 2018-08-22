<?php

namespace Validators;

class GameValidator
{
    public $boardWidth = 0;

    public $boardHeight = 0;

    public $randomCells = 0;

    public $previousBoardCells = [];

    public $errors = [];

    public function __construct($postData = [])
    {
        $this->boardWidth = $this->validateBoardWidth($postData);

        $this->boardHeight = $this->validateBoardHeight($postData);

        $this->randomCells = $this->validateRandomCells($postData);

        $this->previousBoardCells = $this->validatePreviousBoardCells($postData);

        if (! empty($this->errors)) {
            header('HTTP/1.1 500 Internal Server Error');
            exit(json_encode($this->errors));
        }
    }

    private function validatePreviousBoardCells($postData)
    {
        if (! isset($postData['cells'])) {
            return 0;
        }

        if (is_array($postData['cells']))
        {
            return $postData['cells'];
        }

        array_push($this->errors, 'Board Cells');
    }

    private function validateRandomCells($postData = [])
    {
        if (! isset($postData['random_cells'])) {

            return 0;
        }

        if (is_numeric($postData['random_cells']) && $postData['random_cells'] <= ($this->boardWidth * $this->boardHeight))
        {
            return $postData['random_cells'];
        }

        array_push($this->errors, 'Random cells must be numeric and cannot be more than total number of cells');
    }

    private function validateBoardWidth($postData = [])
    {
        if (! isset($postData['width'])) {
            return 0;
        }

        if (preg_match('/^([0-9]|[1-8][0-9]|9[0-9]|100)$/', $postData['width']))
        {
            return $postData['width'];
        }

        array_push($this->errors, 'Board width should be numeric value between 0 and 100');
    }

    private function validateBoardHeight($postData = [])
    {
        if (! isset($postData['height'])) {
            return 0;
        }

        if (preg_match('/^([0-9]|[1-8][0-9]|9[0-9]|100)$/', $postData['height']))
        {
            return $postData['height'];
        }

        array_push($this->errors, 'Board height should be numeric value between 0 and 100');
    }
}
