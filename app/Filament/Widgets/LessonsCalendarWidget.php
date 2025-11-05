<?php

namespace App\Filament\Widgets;

use App\Models\Lessons;
use Filament\Widgets\Widget;
use Saade\FilamentFullCalendar\Data\EventData;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Illuminate\Support\Str;


class LessonsCalendarWidget extends FullCalendarWidget
{
public function fetchEvents(array $fetchInfo): array
    {
        return Lessons::query()
            ->where('starts_at', '>=', $fetchInfo['start'])
            ->where('ends_at', '<=', $fetchInfo['end'])
            ->get()
            ->map(
                fn (Lessons $event) =>
                    EventData::make()
                    ->id($event->id)
                    ->title($event->classrooms()->first()->name.' - '.$event->name)
                    ->start($event->starts_at)
                    ->end($event->ends_at)
                    ->backgroundColor($event->rooms()->first()?->color)
                    ->borderColor($event->rooms()->first()?->color)
                    ->textColor($event->rooms()->first()?->textColor)
                    //->extendedProps(['ftitle' => htmlspecialchars($event->name)])
                    ->extendedProps(['ftitle' => $event->courses()->first()->name.' - '.$event->classrooms()->first()->name.' - '.$event->teacher()->first()->full_name.': '.$event->name])


            )
            ->toArray();
    }

        public function eventDidMount(): string
    {
        return <<<JS
            function({ event, timeText, isStart, isEnd, isMirror, isPast, isFuture, isToday, el, view }){

                el.setAttribute('x-tooltip', 'tooltip');
                el.setAttribute('x-data', '{ tooltip: "'+event.extendedProps.ftitle+'" }');
            }
        JS;
    }

    protected function headerActions(): array
    {
        return [
            //Actions\CreateAction::make(),
        ];
    }

    public static function canView(): bool
    {
        return true;
    }


}
