<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\{PessoaJuridica, Servico, ServicoHorario};

class PessoaJuridicaServico extends Model
{
    use  HasFactory;
    protected $table = 'pessoa_juridica_servico';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    protected $fillable = ["pessoa_juridica_id","servico_id"];

    public function servicoHorario()
    {
        return $this->hasMany(ServicoHorario::class, 'pessoa_juridica_servico_id', 'id');
    }
    public function agendamento()
    {
        return $this->hasManyThrough(Agendamento::class, ServicoHorario::class);
    }
    public function pessoaJuridica()
    {
        return $this->belongsTo(PessoaJuridica::class, 'pessoa_juridica_id');
    }
    public function servico()
    {
        return $this->belongsTo(Servico::class, 'servico_id');
    }
}
