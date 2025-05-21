<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agendamento extends Model
{
    use HasFactory;
    protected $table = 'agendamento';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    protected $fillable = [
        "pessoa_fisica_id",
        "servico_horario_id",
        "data_hora_agendamento",
        "data_hora_conclusao",
        "status_agendamento_id",
        "observacao"
    ];
}
