<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
    use HasFactory;

    protected $table = 'avaliacoes';
    protected $fillable = ['user_id', 'comentario'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
