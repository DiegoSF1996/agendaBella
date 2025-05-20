<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PessoaFisica extends Model
{
    use HasFactory;
    protected $table = 'pessoa_fisica';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    protected $fillable = ["nome","user_id","cpf","data_nascimento","telefone"];
}
