<?php

namespace Gondellier\UniversignBundle\Classes\Request;

class SignatureField extends Base
{
    /**
     * The name of the field. If the PDF already contains a named signature field, you can use this parameter instead of giving the coordinates (which will be ignored).
     * If the name of this field does not exist in the document, the given coordinates will be used instead.
     */
    public $name;
    /**
     * The page on which the field must appear (starting at ’1’ for the first page).
     * Pages are enumerated starting at 1. The value ’-1’ points at the last page.
     */
    public $page;
    /**
     * The field horizontal coordinate on the page.
     */
    public $x;
    /**
     * The field vertical coordinate on the page.
     */
    public $y;

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @param mixed $page
     */
    public function setPage($page): void
    {
        $this->page = $page;
    }

    /**
     * @param mixed $x
     */
    public function setX($x): void
    {
        $this->x = $x;
    }

    /**
     * @param mixed $y
     */
    public function setY($y): void
    {
        $this->y = $y;
    }

}