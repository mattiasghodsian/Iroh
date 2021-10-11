<?php
get_header();

if ( template()->type() != false ){
    template()->route();
}else{
    the_content();
}

get_footer();