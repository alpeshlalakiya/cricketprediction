<?php
/**
 * Created by PhpStorm.
 * User: roshani
 * Date: 6/5/19
 * Time: 11:04 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;
    protected $table = 'users';
}