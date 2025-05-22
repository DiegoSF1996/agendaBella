<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PessoaJuridica extends Model
{
    use HasFactory;
    protected $table = 'pessoa_juridica';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    protected $fillable = ["nome_fantasia","cnpj","telefone","user_id"];
}
