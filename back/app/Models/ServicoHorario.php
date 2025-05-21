<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Agendamento;

class ServicoHorario extends Model
{
    use  HasFactory;
    protected $table = 'servico_horario';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    protected $fillable = ["pessoa_juridica_servico_id", "dia_semana", "horario_inicio", "horario_fim", "tempo_medio"];

    public function agendamento()
    {
        return $this->hasMany(Agendamento::class, 'servico_horario_id', 'id');
    }
}
