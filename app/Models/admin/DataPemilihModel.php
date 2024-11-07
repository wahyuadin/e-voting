<?php

namespace App\Models\admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPemilihModel extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

    public function user() {
        return $this->hasMany(User::class, 'user_id');
    }

    public function kandidat() {
        return $this->hasMany(KandidatModel::class, 'kandidat_id');
    }

    public static function showData($id = null) {
        return $id ? DataPemilihModel::where('kandidat_id', $id)->with('user', 'kandidat')->get() : DataPemilihModel::with('user', 'kandidat')->latest()->get();
    }
}
