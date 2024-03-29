<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Permission;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    protected $table='users';

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'member_by',
        'company_name',
        'country',
        'city',
        'profile',
        'currency',
        'currencyCode',
        'currencySymbol',
        'address',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getPermissionGroups(){
        $permission_group = Permission::select('group_name as name')->groupBy('group_name')->where('guard_name','web')->get();
        return $permission_group;
    }
    public static function getPermissionsByGroupName($name){
        $permissions = Permission::where('group_name',$name)->where('guard_name','web')->get();
        return $permissions;
    }

    public static function roleHasPermissions($role ,$permissions){
        $hasPermission = true;
        foreach($permissions as $permission){
            if(!$role->hasPermissionTo($permission->name)){
                $hasPermission=false;
                return $hasPermission;
            }
        }
        return $hasPermission;
    }

    public function getProfileAttribute($value)
    {
       if($value==''){
        return $value;
       }else{
        return env('PROD_URL').$value;
       }
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function estimatequotes()
    {
        return $this->hasMany(Estimatequote::class, 'user_id');
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'user_id');
    }

    public function cases()
    {
        return $this->hasMany(Casemanagement::class, 'user_id');
    }


}
