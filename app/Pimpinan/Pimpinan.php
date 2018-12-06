<?php

namespace App\Pimpinan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class Pimpinan extends Authenticatable
{
    use Notifiable;
    protected $table = 'tb_pimpinan';
    protected $primaryKey = 'id_pimpinan';
}
