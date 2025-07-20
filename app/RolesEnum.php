<?php
namespace App;
enum RolesEnum: string
{
    // case NAMEINAPP = 'name-in-database';
    case ADMIN = 'admin';
    case AGENT = 'agent';
    case CUSTOMER = 'customer';

    // extra helper to allow for greater customization of displayed values, without disclosing the name/value data directly
    public function label(): string
    {
        return match ($this) {
            static::ADMIN => 'Admin',
            static::AGENT => 'Agent',
            static::CUSTOMER => 'Customer',
        };
    }
}
