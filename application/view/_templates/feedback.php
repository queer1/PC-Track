<?php

// get the feedback (they are arrays, to make multiple positive/negative messages possible)
$feedback_positive = Session::get('feedback_positive');
$feedback_negative = Session::get('feedback_negative');

// echo out positive messages
if(isset($feedback_positive)) {
    foreach($feedback_positive as $feedback) {
        echo '<ul class="collection"> <li class="collection-item green">' . $feedback . '</li></ul>';
    }
}

// echo out negative messages
if(isset($feedback_negative)) {
    foreach($feedback_negative as $feedback) {
        echo '<ul class="collection"> <li class="collection-item red darken-1">' . $feedback . '</li></ul>';
    }
}
