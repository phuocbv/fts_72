<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
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
     * Get the exams for the subject.
     */
    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    /**
     * Get the questions for the subject.
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
