<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Book extends Model
{
    use HasFactory;

    /**
     * Add a foreign key in the reviews table to reference the ID in the books table.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Scope to search books by title.
     *
     * @param  Builder  $query
     * @param  string  $title
     * @return Builder
     */
    public function scopeTitle(Builder $query, string $title): Builder
    {
        return $query->where('title', 'LIKE', '%' . $title . '%');
    }

    /**
     * Scope to retrieve books sorted by popularity.
     *
     * @param  Builder  $query
     * @param  mixed|null  $from
     * @param  mixed|null  $to
     * @return Builder|QueryBuilder
     */
    public function scopePopular(Builder $query, $from = null, $to = null): Builder|QueryBuilder
    {
        return $query->withCount([
            'reviews' => fn (Builder $q) => $this->dateRangeFilter($q, $from, $to)
        ])
            ->orderBy('reviews_count', 'desc');
    }

    /**
     * Scope to retrieve books sorted by average rating.
     *
     * @param  Builder  $query
     * @param  mixed|null  $from
     * @param  mixed|null  $to
     * @return Builder|QueryBuilder
     */
    public function scopeHighestRated(Builder $query, $from = null, $to = null): Builder|QueryBuilder
    {
        return $query->withAvg([
            'reviews' => fn (Builder $q) => $this->dateRangeFilter($q, $from, $to)
        ], 'rating')
            ->orderBy('reviews_avg_rating', 'desc');
    }

    /**
     * Filter books by the start date and end date.
     *
     * @param  Builder  $query
     * @param  mixed|null  $from
     * @param  mixed|null  $to
     * @return Builder|QueryBuilder
     */
    private function dateRangeFilter(Builder $query, $from = null, $to = null)
    {
        if ($from && !$to) {
            $query->where('created_at', '>=', $from);
        } elseif (!$from && $to) {
            $query->where('created_at', '<=', $to);
        } elseif ($from && $to) {
            $query->whereBetween('created_at', [$from, $to]);
        }
    }
}
