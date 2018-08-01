<?php
namespace App\Entity;
use Illuminate\Database\Eloquent\Model;

/**
 * Created by PhpStorm.
 * User: dlj930
 * Date: 2018/7/27
 * Time: 11:07
 */
class PdtContent extends Model
{
    protected $table = 'pdt_content';
    protected $primaryKey = 'id';
    public $timestamps = true;
}