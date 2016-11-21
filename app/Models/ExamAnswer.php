<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamAnswer extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the result that owns the answer.
     */
    public function result()
    {
        return $this->belongsTo(Result::class);
    }

    /**
     * Get the system anwers that owns the exam answer.
     */
    public function systemAnswer()
    {
        return $this->belongsTo(SystemAnswer::class);
    }
}
