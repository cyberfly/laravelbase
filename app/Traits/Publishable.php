<?php

namespace App\Traits;

use App\Models\Common\PublishStatus;
use Illuminate\Database\Eloquent\Builder;

trait Publishable
{
    /**
     * Scope a query to only include published models.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished(Builder $query)
    {
        return $query->where('publish_status', PublishStatus::PUBLISH);
    }

    /**
     * Scope a query to only include unpublished models.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDraft(Builder $query)
    {
        return $query->where('publish_status', PublishStatus::DRAFT);
    }

    /**
     * @return bool
     */
    public function isPublished()
    {
        if ($this->publish_status === PublishStatus::PUBLISH) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isDraft()
    {
        return !$this->isPublished();
    }

    /**
     * @return bool
     */
    public function publish()
    {
        return $this->update([
            'publish_status' => PublishStatus::PUBLISH,
            'published_at' => now(),
        ]);
    }

    /**
     * @return bool
     */
    public function draft()
    {
        return $this->update([
            'publish_status' => PublishStatus::DRAFT,
            'published_at' => null,
        ]);
    }
}