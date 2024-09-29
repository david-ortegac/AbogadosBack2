<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Process
 *
 * @property $id
 * @property Process $processId
 * @property $applicationDate
 * @property $processTitle
 * @property $processStatus
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin Builder
 */
class History extends Model
{
    use HasFactory;

    protected $perPage = 20;

    protected $fillable = [
        '$processId',
        'applicationDate',
        'processTitle',
        'processStatus',
    ];

    public function process(): HasOne{
        return $this->hasOne(Process::class, 'id', 'processId');
    }
}
