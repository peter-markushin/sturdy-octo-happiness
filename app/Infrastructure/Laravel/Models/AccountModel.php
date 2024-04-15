<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Models;

use DateTimeImmutable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property string $type
 * @property int $balance
 * @property UserModel $user
 * @property DateTimeImmutable $created_at
 * @property DateTimeImmutable $updated_at
 */
class AccountModel extends BaseModel
{
    use HasFactory;
    use HasUlids;

    public $timestamps = true;

    protected $table = 'accounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'balance',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class);
    }
}
