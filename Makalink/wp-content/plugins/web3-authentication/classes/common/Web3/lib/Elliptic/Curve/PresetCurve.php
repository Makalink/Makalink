<?php

namespace Elliptic\Curve;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
require_once "ShortCurve.php";
require_once "MontCurve.php";
require_once "EdwardsCurve.php";

if ( ! class_exists( 'Elliptic\Curve\PresetCurve' ) ) {

    class PresetCurve
    {
        public $curve;
        public $g;
        public $n;
        public $hash;

        function __construct($options)
        {
            if ( $options["type"] === "short" )
                $this->curve = new ShortCurve($options);
            elseif ( $options["type"] === "edwards" )
                $this->curve = new EdwardsCurve($options);
            else
                $this->curve = new MontCurve($options);

            $this->g = $this->curve->g;
            $this->n = $this->curve->n;
            $this->hash = isset($options["hash"]) ? $options["hash"] : null;
        }
    }
}
?>
