<?php

namespace App\Enums;

enum UserPermission: int
{
    case SPECTATOR = 1;
    case MEMBER = 2;
    case ADMINISTRATOR = 3;
    case OWNER = 4;
}
