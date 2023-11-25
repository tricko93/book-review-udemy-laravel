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
     * Scope to retrieve books with a minimum number of reviews.
     * 
     * @param  Builder  $query
     * @param  int  $minReviews
     * @return Builder|QueryBuilder
     */
    public function scopeMinReviews(Builder $query, int $minReviews): Builder|QueryBuilder
    {
        return $query->having('reviews_count', '>=', $minReviews);
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

    /**
     * Scope that retrieves books with the most reviews in the last month
     * along with their average ratings and books with at least 2 reviews.
     *
     * @param  Builder  $query
     * @return Builder|QueryBuilder
     */
    public function scopePopularLastMonth(Builder $query): 
    Builder|QueryBuilder
    {
        return $query->popular(now()->subMonth(), now())
            ->highestRated(now()->subMonth(), now())
            ->minReviews(2);
    }

    /**
     * Retrieves books with the most reviews in the last 6 months
     * along with their average ratings and books with at least 5 reviews.
     *
     * @param  Builder  $query
     * @return Builder|QueryBuilder
     */
    public function scopePopularLast6Months(Builder $query): 
    Builder|QueryBuilder
    {
        return $query->popular(now()->subMonths(6), now())
            ->highestRated(now()->subMonths(6), now())
            ->minReviews(5);
    }

    /**
     * Retrieves books with the average ratings in the last month
     * along with their popularity ratings and books with at least 2 reviews.
     *
     * @param  Builder  $query
     * @return Builder|QueryBuilder
     */
    public function scopeHighestRatedLastMonth(Builder $query): 
    Builder|QueryBuilder
    {
        return $query->highestRated(now()->subMonth(), now())
            ->popular(now()->subMonth(), now())
            ->minReviews(2);
    }

    /**
     * Retrieves books with the average ratings in the last 6 months
     * along with their popularity ratings and books with at least 5 reviews.
     *
     * @param  Builder  $query
     * @return Builder|QueryBuilder
     */
    public function scopeHighestRatedLast6Months(Builder $query): 
    Builder|QueryBuilder
    {
        return $query->highestRated(now()->subMonths(6), now())
            ->popular(now()->subMonths(6), now())
            ->minReviews(5);
    }
}
