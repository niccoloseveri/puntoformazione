<?php

namespace App\Livewire;

use App\Models\Lessons;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Data\EventData;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Illuminate\Support\Str;

class UserCalendarWidget extends FullCalendarWidget
{
    public Model | string | null $model = Lessons::class;

    public function config(): array
    {
        return [
            'eventDisplay' => 'block',
        ];
    }

    public function textColor($event) {
        $color = ltrim($event->rooms()->first()?->color, '#');
        $json =file_get_contents('https://webaim.org/resources/contrastchecker/?fcolor=000000&bcolor='.$color.'&api');
        $djson = json_decode($json,true);
        $c = $djson['AA'] == 'pass' ? "#000000" : "#FFFFFF";
        return $c;
    }

    public function fetchEvents(array $fetchInfo): array
    {
        return Lessons::query()
            ->where('starts_at', '>=', $fetchInfo['start'])
            ->where('ends_at', '<=', $fetchInfo['end'])
            ->leftJoinRelationship('subscriptions')
            ->where('subscriptions.user_id', auth()->user()->id)
            ->get()
            ->map(
                fn (Lessons $event) =>
                    EventData::make()
                    ->id($event->id)
                    ->title(Str::limit($event->name, 12, '...'))
                    ->start($event->starts_at)
                    ->end($event->ends_at)
                    ->backgroundColor($event->rooms()->first()?->color)
                    ->borderColor($event->rooms()->first()?->color)
                    ->textColor($event->rooms()->first()?->textColor)
                    //->extendedProps(['ftitle' => htmlspecialchars($event->name)])
                    ->extendedProps(['ftitle' => $event->name])


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
}
