<?php

namespace App;

trait RecordActivity
{
    /**
     * Boot the trait.
     */
    protected static function bootRecordActivity()
    {
        if (auth()->guest()) {
            return;
        }
        foreach (static::getActivitiesToRecord() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });

            static::deleting(function ($model) {
                $model->activity()->delete();
            });
        }
    }

    /**
     * Fetch all model events that require activity recording.
     *
     * @return array
     */
    protected static function getActivitiesToRecord()
    {
        return ['created'];
    }

    protected function recordActivity($event)
    {
        $this->activity()->create([
            'user_id'=>auth()->id(),
            'type'=>$this->getActivityType($event)
        ]);
    }

    protected function getActivityType($event)
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());

        return "{$event}_{$type}";
    }

    public function activity()
    {
        return $this->morphMany('App\Activity', 'subject');
    }
}
