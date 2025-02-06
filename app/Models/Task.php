<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'due_date', 'target_id', 'owner_id', 'status'
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function target(): BelongsTo
    {
        return $this->belongsTo(User::class, 'target_id');
    }

    public function statusAlias(): string
    {
        $alias = '';
        if($this->status == TaskStatus::PENDING) {
            $alias = 'pending';
        } elseif ($this->status == TaskStatus::IN_PROGRESS) {
            $alias = 'in progress';
        } elseif ($this->status == TaskStatus::COMPLETED) {
            $alias = 'completed';
        }

        return $alias;
    }
}
