<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Approval extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $hidden = ['model_type'];

    protected static function booted()
    {
//        dd(auth()->user());
        if(auth()->user()) {
            static::creating(function ($model) {
                $model->data = serialize(request()->all()) ?? null;
                $model->created_by = auth()->user()->id;
                $model->model_type = request()->model;
                $model->model_id = request()->user->id ?? null;
                $model->action = request()->action;
            });
        }

        static::retrieved(function ($model){
            if(request()->isMethod('GET'))
            $model->data = unserialize($model->data);
        });
    }

    public static function updateApproval($user)
    {
        self::query()->update([
            'model_id' => $user,
            'approved_by' => auth()->user()->id,
            'approved_at' => now()
        ]);
    }

    public function createdBy():belongsTo
    {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function approvedBy():belongsTo
    {
        return $this->belongsTo(User::class,'approved_by','id');
    }

    public function approvalModel():belongsTo
    {
        return $this->belongsTo(User::class,'model_id','id');
    }
}
