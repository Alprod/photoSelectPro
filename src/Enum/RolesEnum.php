<?php

namespace App\Enum;

enum RolesEnum
{
    case ROLE_USER;
    case ROLE_CLIENT;
    case ROLE_ADMIN;
    case ROLE_SUPER_ADMIN;
    case IS_AUTHENTICATED_FULLY;

}
