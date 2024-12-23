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
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kandidat() {
        return $this->belongsTo(KandidatModel::class, 'kandidat_id');
    }

    public static function showData($id = null) {
        return $id ? DataPemilihModel::where('user_id', $id)->with('user', 'kandidat')->get() : DataPemilihModel::with('user', 'kandidat')->latest()->get();
    }

    public static function tambahData($data) {
        return DataPemilihModel::create($data);
    }
}
