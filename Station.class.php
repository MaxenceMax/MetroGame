<?php


class Station {
    public $id;
    public $name;
    public $x;
    public $y;
    public $type;
    
    public function __construct($id, $name, $x, $y, $type) {
        $this->id = $id;
        $this->name = $name;
        $this->x = $x;
        $this->y = $y;
        $this->type = $type;
    }
}
?>
