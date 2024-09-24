<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;


/**
 * Class Process
 *
 * @property $id
 * @property $documentType
 * @property $documentNumber
 * @property $name
 * @property $lastName
 * @property $nationality
 * @property $applicationDate
 * @property $pendingPayment
 * @property $processTitle
 * @property $processStatus
 * @property $status
 * @property $validationKey
 * @property $Link
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin Builder
 */
class Process extends Model
{

    static $rules = [
		'processId'=>'required',
        'documentType' => 'required',
        'documentNumber' => 'required|unique:processes',
        'name' => 'required',
        'lastName' => 'required',
        'nationality' => 'required',
        'applicationDate' => 'required|date',
        'pendingPayment' => 'required',
        'processTitle'=>'required',
        'processStatus' => 'required',
        'Link' => 'required',
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
		'processId',
        'documentType',
        'documentNumber',
        'name',
        'lastName',
        'nationality',
        'applicationDate',
        'pendingPayment',
        'processStatus',
        'processTitle',
        'status',
        'validationKey',
        'Link',
    ];

}
