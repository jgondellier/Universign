<?php

namespace Gondellier\UniversignBundle\Classes\Request;

class DocSignatureField extends SignatureField
{
    /**
     * The index of the signer which uses this field. Signers are enumerated starting at 0.
     */
    public $signerIndex;
    /**
     * The name of the pattern. May be used if more than one pattern is set. The default value is "default". The magic value "invisible" means that the field
     * will not be visible in the PDF.
     */
    public $patternName;
    /**
     * A label which defines the signature field. This label will be printed in the signature page if set. If a signer has more than one field on the same document,
     * label becomes mandatory.
     */
    public $label;
    /**
     * The image to be displayed in the signature field, it will replace the default UNIVERSIGN logo. Image format must be JPG, JPEGor PNG.
     * A recommended resolution for this image is 150x36px. The image will be resized if the image has a different resolution.
     */
    public $image;

    /**
     * @param mixed $signerIndex
     */
    public function setSignerIndex($signerIndex): void
    {
        $this->signerIndex = $signerIndex;
    }

    /**
     * @param mixed $patternName
     */
    public function setPatternName($patternName): void
    {
        $this->patternName = $patternName;
    }

    /**
     * @param mixed $label
     */
    public function setLabel($label): void
    {
        $this->label = $label;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }


}