<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
		'processId'=>"required|unique:processes",
        'applicationDate' => 'required',
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
        'processTitle',
        'processStatus',
        'status',
    ];

    public function user(): HasOne
    {
        return $this->HasOne('App\Models\User', 'id', 'userId');
    }

    public function history(): HasOne{

        return $this->HasOne('App\Models\History', 'processId', 'id');
    }

}
