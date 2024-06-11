<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model implements Authenticatable
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


    // implementasi Authenticable
    public function getAuthIdentifierName()
    {
        // Identifier atau Id nya untuk user nya itu apa?
        return 'username'; // karena yang dipakai username
    }

    public function getAuthIdentifier()
    {
        // Dapatkan nilai username nya siapa?
        return $this->username;
    }

    public function getAuthPassword()
    {
        // Dapatkan nilai password
        return $this->password;
    }

    public function getRememberToken()
    {
        // Untuk dapatkan token;
        return $this->token;

    }

    public function setRememberToken($value)
    {
        $this->token = $value;
    }

    public function getRememberTokenName(){
        return 'token';
    }
}
