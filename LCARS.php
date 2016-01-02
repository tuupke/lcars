<?php


class LCARSButton
{
    public static function create() {
        return new LCARSButton();
    }

    public function __toString() {
        return "Button";
    }
}

class LCARSPage
{

    private $generator;

    private function __construct(Callable $c) {
        $this->generator = $c;
    }

    public static function create(Callable $c) {
        return new LCARSPage($c);
    }

    public function __toString() {
        $color = LCARS::ORANGE;

        $string = "
            <div class='pageOuter pageOuterTopLeft pageOuterBottomLeft' style='background-color: $color;'>
                  <div class='pageInner'>";

        $call = $this->generator;
        $content = $call();
        $string .= empty($content) ? "&nbsp<br /><br /><br />" : $content;

        $string .= "</div></div>";

        return $string;
    }
}

class LCARS
{

    // Source: http://www.lcarscom.net/faq.htm
    const ORANGE = "#f90";
    const PINK = "#c69";
    const OKER = "#f96";
    const BLUE = "#99f";
    const YELLOW = "#fc9";
    const RED = "#c66";
    const PALEBLUE = "#99c";
    const PALEPINK = "#c9c";

    private $parts = [];

    public function page(Callable $c) {
        $this->parts[] = function () use ($c) {
            return LCARSPage::create($c);
        };

        return $this;
    }

    public static function button() {
        return LCARSButton::create();
    }

    public static function create() {
        return new LCARS();
    }

    public function __toString() {
        return $this->build();
    }

    private function build() {
        $ret = "";
        foreach ($this->parts as $part) {
            $ret .= "" . $part();
        }

        return $ret;
    }
}
