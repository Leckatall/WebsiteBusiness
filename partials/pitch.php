<?php //$orientation = "LTR";
//$title = "Sophisticated and Personable Designs";
//$subtitle = "Personalisation to satisfy the perfectionist business owner
//<b>and</b>
//the care-free blogger";
//$img_path = "images/HappyLaptopWoman.jpg";
//$img_alt = "Businesswoman";
class Pitch{
    public $orientation;
    public $title;
    public $subtitle;
    public $img_path;
    public $img_alt;

    function __construct($orientation, $title, $subtitle, $img_path, $img_alt){
        $this->orientation = $orientation;
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->img_path = $img_path;
        $this->img_alt = $img_alt;
    }

    function construct(){
        return "
        <section class='pitch pitch-$this->orientation'>
    <img src='$this->img_path' alt='$this->img_alt'>
    <h2 class='titles title'>$this->title</h2>
    <div class='titles sub-title'>$this->subtitle</div>
</section> ";
    }
}

?>


