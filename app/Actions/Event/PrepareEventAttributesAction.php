<?php

namespace App\Actions\Event;

use Recurr\Transformer\ArrayTransformerConfig;
use Recurr\Rule;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use App\User;

class PrepareEventAttributesAction
{
    private Collection $attributes;


    public function execute(array $attributes): array
    {
        $this->attributes = $this->normalize($attributes);

        return [
            'input' => [
                'name' => $this->attributes['name'],
                'occurrence' => empty($this->getOccurrence()) ? null : $this->getOccurrence()->getString(),
                'starts_at' => $this->attributes['fullStartsAtDate'],
                'ends_at' => $this->attributes['allDay'] ? Carbon::parse($this->attributes['endsAtDate'])->endOfDay() : $this->attributes['fullEndsAtDate'],
                'all_day' => $this->attributes['allDay'],
                'event_id' => null,
                'color' => $this->attributes['color'],
                'event-trixFields' => $this->attributes['event-trixFields'],
                'attachment-event-trixFields' => $this->attributes['attachment-event-trixFields'],
            ],

            'assignedTo' => $this->attributes['assignedTo'],
            'notifiedUsers' => $this->attributes['notifiedUsers']
        ];
    }


    private function getOccurrence()
    {
        if (!strToBool($this->attributes['repeat'])) {
            return null;
        }

        $rule = new Rule;

        $rule->setStartDate($this->attributes['fullStartsAtDate'], true);
        $rule->setEndDate($this->attributes['fullEndsAtDate']);

        switch ($this->attributes['repeat']) {
            case 'otherDay':
                $rule->setFreq('DAILY')->setInterval(2);
                break;
            case 'otherWeek':
                $rule->setFreq('WEEKLY')->setInterval(2);
                break;
            case 'weekend':
                $rule->setFreq('WEEKLY')->setByDay(['FR', 'SA']);
                break;
            case 'weekday':
                $rule->setFreq('WEEKLY')->setByDay(['SU', 'MO', 'TU', 'WE', 'TH']);
                break;
            default:
                $rule->setFreq($this->attributes['repeat']);
                break;
        }

        if ($this->attributes['repeatPeriod'] !== 'forever') {
            $repeatUntil = carbon::parse($this->attributes['repeatUntil']);
            $until = $repeatUntil->isPast() ? Carbon::parse($this->attributes['endsAtDate']) : $repeatUntil;
            $rule->setUntil($until);
        }


        if ($this->attributes['allDay']) {
            $endDate = Carbon::parse($this->attributes['endsAtDate']);

            $rule->setStartDate(Carbon::parse($this->attributes['startsAtDate']), true);
            $rule->setEndDate($endDate->copy()->endOfDay());
        }

        $rule->setExDates([$this->attributes['fullStartsAtDate'], $this->attributes['fullEndsAtDate']]);

        return $rule;
    }

    private function prepareUsers(?string $userString = null): Collection
    {
        if (is_null($userString)) {
            return collect();
        }

        return User::findOrFail(strToArray($userString));
    }

    private function normalize(array $attributes): Collection
    {
        return collect([
            'name' => $attributes['name'],
            'color' => $attributes['color'],
            'allDay' => strToBool($attributes['allDay']),
            'startsAtDate' => $attributes['startsAtDate'],
            'startsAtTime' => $attributes['startsAtTime'],
            'endsAtDate' => $attributes['endsAtDate'],
            'endsAtTime' => $attributes['endsAtTime'],
            'fullStartsAtDate' => Carbon::parse("{$attributes['startsAtDate']} {$attributes['startsAtTime']}"),
            'fullEndsAtDate' => Carbon::parse("{$attributes['endsAtDate']} {$attributes['endsAtTime']}"),
            'repeat' => $attributes['repeat'],
            'repeatPeriod' => $attributes['repeat'] === "no" ? null : $attributes['repeatPeriod'],
            'repeatUntil' => $attributes['repeatUntil'],
            'assignedTo' => $this->prepareUsers($attributes['assignedTo']),
            'event-trixFields' => empty($attributes['event-trixFields']) ? null : $attributes['event-trixFields'],
            'attachment-event-trixFields' => empty($attributes['attachment-event-trixFields']) ? null : $attributes['attachment-event-trixFields'],
            'notifiedUsers' =>  strToBool($attributes['notifyUsers']) ? collect() : $this->prepareUsers($attributes['notifiedUsers'])
        ]);
    }
}
