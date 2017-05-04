<?php

class Categoria
{
    public $id;
    public $rotulo;
    public $count = 0;
    public $percent = 0;


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


    public function getTopic()
    {
        switch( $this->id ){
            case 1:
                return '/topics/categoria_1';
            case 2:
                return '/topics/categoria_2';
            case 3:
                return '/topics/categoria_3';
            case 4:
                return '/topics/categoria_4';
            default:
                return '/topics/categoria_5';
        }
    }


    public function calcPercent( $total )
    {
        if( $total == 0 ){
            return;
        }
        $this->percent = ($this->count / $total) * 100;
    }


    public function getPercentAsString()
    {
        return sprintf('%.1f', $this->percent).'%';
    }
}