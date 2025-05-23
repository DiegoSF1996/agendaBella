<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Servico extends Model
{
    use HasFactory;
    protected $table = 'servico';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    protected $fillable = ["descricao"];
}
