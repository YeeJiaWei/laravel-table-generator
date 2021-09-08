<?php


namespace YeeJiaWei\TableGenerator\Column;

use Illuminate\Support\Str;

class ImageColumn extends Column
{
    public $path;

    public $default_path;

    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->path = asset('storage');
        $this->default_path = asset('image/image-not-available.png');
    }

    public function path(string $path)
    {
        $this->path = $path;

        return $this;
    }

    public function default(string $path)
    {
        $this->default_path = $path;

        return $this;
    }
}