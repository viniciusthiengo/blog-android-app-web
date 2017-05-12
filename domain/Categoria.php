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


    public function getTopic()
    {
        return '/topics/categoria_'.$this->id;
    }


    public function calcPercent( $totalTokens )
    {
        if( $totalTokens == 0 ){
            return;
        }

        $this->percent = ($this->count / $totalTokens) * 100;
    }


    public function getPercentAsString()
    {
        return sprintf( '%.1f', $this->percent ).'%';
    }
}