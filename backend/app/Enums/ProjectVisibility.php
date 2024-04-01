<?php

namespace App\Enums;

enum ProjectVisibility: int
{
    case PRIVATE = 1;
    case MEMBERS = 2;
    case PUBLIC = 3;
}
