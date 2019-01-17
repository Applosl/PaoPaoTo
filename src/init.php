<?php
/**
 * Created by PaoPaoTo.
 * User: pol
 * Date: 2019/1/16
 * Time: 4:15 PM
 */

namespace PaoPaoTo;

use PaoPaoTo\kernel\PPT;

function init() {
    return PPT::getInstance();
}
