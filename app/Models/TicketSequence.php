<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;


class TicketSequence extends Model
{
    use HasUuids, Notifiable;
    protected $table = 'ticket_sequences';

    public $timestamps = false;

    protected $fillable = ['jenis', 'tahun', 'terakhir'];
}
