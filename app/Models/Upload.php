<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Upload extends Model
{
    use HasFactory;

    protected $table = 'tbl_uploads';

    protected $fillable = [
        'uploadable_id',
        'uploadable_type',
        'file_type',
        'file_path',
        'folder',
        'original_name',
        'field_name'
    ];

    /**
     * Get the parent uploadable model (Admin, User or media).
     */
    public function uploadable()
    {
        return $this->morphTo();
    }

    /**
     * Register any events for your application.
     *
     * @return void
     */
    protected static function booted(): void
    {
        // If uploaded file record deleted from any model
        static::deleted(function ($upload) {
            // Delete file from storage folder too
            Storage::disk('public')->delete($upload->file_path);
        });
    }
}
