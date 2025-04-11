<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetCountPlot extends Model
{
    use HasFactory;
    protected $table = 'asset_count_plot';
    protected $fillable = [
        'asset_count_id',
        'asset_id',
        'location_id',
        'company_id',
        'department_id',
        'isScanned',
        'scannedby',
        'scanned_at',
        'updatedby',
        'createdby',
        'created_at',
        'updated_at',
    ];

    public function asset_count()
    {
        return $this->belongsTo(AssetCount::class, 'asset_count_id', 'id');
    }
    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id', 'id');
    }
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'location_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    
}
