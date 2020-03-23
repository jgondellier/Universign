<?php

namespace App\Util;


use Gondellier\UniversignBundle\Classes\Request\TransactionSigner;

class ImageSignature
{
    private $colour;
    private $font;
    private $size;

    public function create(TransactionSigner $signer,$text)
    {
        $img = imagecreatetruecolor(150, 36);
        $this->colour = imagecolorallocate($img, 24, 33, 29);
        $this->addText($img,$text,145,32);
        return imagepng($img);
    }
    private function addText($img,$txt,$x,$y,$colour=null,$orientation =0,$size=24,$font=null):void
    {
        if($colour === null){
            $colour = $this->colour;
        }
        if($font === null){
            $font = $this->font;
        }

        imagettftext($img, $size, $orientation, $x, $y, $colour, $font, $txt);

    }
}