<?php

class Categoria
{
    public $id;
    public $rotulo;


    public function setId($id)
    {
        $this->id = $id;
    }


    public function setRotulo($rotulo)
    {
        $this->rotulo = $rotulo;
    }


    public function getMobIcon()
    {
        switch( $this->id ){
            case 1:
                return 'ic_categoria_1';
            case 2:
                return 'ic_categoria_2';
            case 3:
                return 'ic_categoria_3';
            case 4:
                return 'ic_categoria_4';
            default:
                return 'ic_categoria_5';
        }
    }
}