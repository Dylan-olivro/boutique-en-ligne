<?php

class Image
{
    public $id;
    public $id_item;
    public $path;

    public function __construct($id, $id_item, $path)
    {
        $this->id = $id;
        $this->id_item = $id_item;
        $this->path = $path;
    }
}
