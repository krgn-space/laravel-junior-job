<?php declare(strict_types=1);

namespace App\Models;

use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = ['article', 'name', 'status', 'data'];

    protected $casts = [
        'data' => 'array',
    ];

    /**
     * Scope a query to only include active users.
     */
    public function scopeAvailable(Builder $query): void
    {
        $query->where('status', ProductStatus::Available->value);
    }
}
