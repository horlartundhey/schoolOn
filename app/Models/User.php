<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    static public function getAdmin(){
        $return = self::select('users.*')->where('user_type', '=', 1)->where('is_delete', '=', '0');

                            if(request()->has('name') && !empty(request()->get('name')))
                            {
                                $return = $return->where('name', 'like', '%'.request()->get('name').'%');
                            }
                            if(request()->has('email') && !empty(request()->get('email')))
                            {
                                $return = $return->where('email', 'like', '%'.request()->get('email').'%');
                            }
                            $return = $return->orderBy('id', 'desc')->paginate(2);

                            return $return;
    }


    static public function getSingle($id){
        return self::find($id);
    }


}
