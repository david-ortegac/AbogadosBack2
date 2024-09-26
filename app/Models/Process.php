<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Validator;


/**
 * Class Process
 *
 * @property $id
 * @property $applicationDate
 * @property $pendingPayment
 * @property $processTitle
 * @property $processStatus
 * @property $status
 * @property $created_at
 * @property $updated_at
 * @property User $userId
 *
 * @package App
 * @mixin Builder
 */
class Process extends Model
{

    static $rules = [
		'userId'=>'required',
		'processId'=>'required',
        'applicationDate' => 'required|date',
        'pendingPayment' => 'required',
        'processTitle'=>'required',
        'processStatus' => 'required',
    ];
    /**
     * @var \Illuminate\Support\HigherOrderCollectionProxy|mixed
     */

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
		'userId',
		'processId',
        'applicationDate',
        'pendingPayment',
        'processStatus',
        'processTitle',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'id', 'userId');
    }

}
