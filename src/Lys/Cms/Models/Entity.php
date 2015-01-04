<?php

namespace Lys\Cms\Models;


interface Entity {
    public function isPage();
    public function getTitle();
}