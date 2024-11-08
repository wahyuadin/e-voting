<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KandidatModel extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

    public function pemilih() {
        return $this->hasMany(DataPemilihModel::class, 'kandidat_id');
    }

    public static function showData($id = null) {
        return $id ? KandidatModel::where('id', $id) : KandidatModel::with('pemilih.user','pemilih.kandidat')->latest()->get();
    }

    public static function tambahData($data) {
        return KandidatModel::create($data);
    }

    public static function editData($id, $data) {
        return KandidatModel::find($id)->update($data);
    }

    public static function hapusData($id) {
        return KandidatModel::find($id)->delete();
    }
}
