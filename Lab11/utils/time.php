<?php

const secondsPerDay = 86400;

function getAgoTime($plainTime) {
    return floor((time() - $plainTime) / secondsPerDay);
}