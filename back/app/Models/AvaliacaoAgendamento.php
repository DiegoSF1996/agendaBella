<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AvaliacaoAgendamento extends Model
{
    use HasFactory;
    protected $table = 'avaliacao_agendamento';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    protected $fillable = ["agendamento_id","nota_avaliacao_da_pessoa_fisica","nota_avaliacao_da_pessoa_juridica","observacao_da_pessoa_fisica","observacao_da_pessoa_juridica"];
}
