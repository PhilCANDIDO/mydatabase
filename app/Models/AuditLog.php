<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'username',
        'action_type',
        'table_name',
        'record_id',
        'before_data',
        'after_data',
        'sql_command',
        'ip_address',
        'created_at',
    ];

    protected $casts = [
        'before_data' => 'array',
        'after_data' => 'array',
        'created_at' => 'datetime',
    ];

    const UPDATED_AT = null;
    
    // Pas de updated_at pour les logs d'audit
    public $timestamps = false;

    /**
     * Récupère l'utilisateur associé à cette action d'audit.
     * La relation peut être null si l'utilisateur a été supprimé.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => $this->username . ' (deleted)',
        ]);
    }
    
    /**
     * Récupère le nom d'utilisateur pour l'affichage.
     * Utilise le nom d'utilisateur stocké si l'utilisateur a été supprimé.
     */
    public function getUsernameForDisplay(): string
    {
        return $this->user_id ? $this->user->name : $this->username;
    }
}