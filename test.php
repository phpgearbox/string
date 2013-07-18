<?php

require('Functions.php');

print_r(Gears\String\Between('<p>This is a test</p>', '<p>', '</p>'));

print_r(Gears\String\BetweenPreg('<p>This is a test</p>', '<p>', '</p>'));

print_r(Gears\String\GenRand());
