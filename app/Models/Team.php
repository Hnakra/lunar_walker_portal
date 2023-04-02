<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    // protected $appends = ['groupName'];
    public function groupName(){
        return isset($this->attributes['group']) ?
            range('A', 'Z')[$this->attributes['group']-1] :
            null;
    }
}
