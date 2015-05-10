<?php
namespace UpstatePHP\Website\Domain\Events;

use Laracasts\Presenter\Presenter;

class EventPresenter extends Presenter
{
    public function eventDate()
    {
        switch (true) {
            case $this->begins_at->isSameDay($this->ends_at) :
                return $this->begins_at->format('F j, Y') . ' ' . $this->formatTime();
                break;
            case $this->begins_at->month === $this->ends_at->month :
                return $this->begins_at->format('F j') . ' - ' . $this->ends_at->day . ', ' . $this->ends_at->year;
            default :
                return $this->begins_at->format('F j, Y') . ' - ' . $this->ends_at->format('F j, Y');
        }
    }

    protected function formatTime()
    {
        $beginsFormat = $this->begins_at->minute > 0 ? 'g:i' : 'g';
        $endsFormat = $this->ends_at->minute > 0 ? 'g:ia' : 'ga';

        if ($this->begins_at->format('a') != $this->ends_at->format('a')) {
            $beginsFormat .= 'a';
            $endsFormat .= 'a';
        }

        return $this->begins_at->format($beginsFormat) . '-' . $this->ends_at->format($endsFormat);
    }
}