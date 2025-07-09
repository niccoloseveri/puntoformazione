<?php

namespace App\Livewire;

use App\Models\Lessons;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Data\EventData;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class UserCalendarWidget extends FullCalendarWidget
{
    public Model | string | null $model = Lessons::class;

    public function fetchEvents(array $fetchInfo): array
    {
        return Lessons::query()
            ->where('starts_at', '>=', $fetchInfo['start'])
            ->where('ends_at', '<=', $fetchInfo['end'])
            ->leftJoinRelationship('subscriptions')
            ->where('subscriptions.user_id', auth()->user()->id)
            ->get()
            ->map(
                fn (Lessons $event) => EventData::make()
                    ->id($event->id)
                    ->title($event->name)
                    ->start($event->starts_at)
                    ->end($event->ends_at)
                    /*->url(
                        url: EventResource::getUrl(name: 'view', parameters: ['record' => $event]),
                        shouldOpenUrlInNewTab: true
                    )*/
            )
            ->toArray();
    }

        public function eventDidMount(): string
    {
        return <<<JS
            function({ event, timeText, isStart, isEnd, isMirror, isPast, isFuture, isToday, el, view }){
                el.setAttribute("x-tooltip", "tooltip");
                el.setAttribute("x-data", "{ tooltip: '"+event.title+"' }");
            }
        JS;
    }

    protected function headerActions(): array
    {
        return [
            //Actions\CreateAction::make(),
        ];
    }
}
