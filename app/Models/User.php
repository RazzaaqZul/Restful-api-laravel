<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    protected $table = "users";
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $timestamps = true;
    public $incrementing = true ;

    protected $fillable = [
        'username',
        'password',
        'name'
    ] ;

    public function contacts() : HasMany {

        // user_id : coloum di table contact
        // id : column di table user
        return $this->hasMany(Contact::class, "user_id", "id");
    }
}