<?php
function make_pitch($title, $subtitle, $orientation, $img_path, $img_alt="an image"){
    $img_path = get_image_src($img_path);
    return "
    <section class='pitch pitch-$orientation'>
        <h2 class='titles title'>$title</h2>
        <div class='titles sub-title'>$subtitle</div>
        <img src='$img_path' alt='$img_alt'>
    </section> ";
}



