<?php
namespace Esatic\activateuser\Models;


class User extends \App\Models\User
{
    protected $fillable = [
        'name',
        'last_name',
        'id_crm',
        'email',
        'password',
        'active'
    ];
}
