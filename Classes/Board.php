<?php

namespace Classes;

class Board
{
    public $width = 10;

    public $height = 10;

    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function setHeight($height)
    {
        $this->height = $height;
    }
}
