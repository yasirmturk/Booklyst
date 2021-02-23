<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Service $service
     * @return \Illuminate\Http\Response
     */
    public function addImage(Request $request, Service $service)
    {
    }

    public function getSchedule(Request $request, Service $service)
    {
        return $service->schedule
            ?? $service->business->schedule
            ?? response(['message' => 'No Schedule found'], 404);
    }

    public function getBookings(Request $request, Service $service, $date = null)
    {
        $date = $this->validateDate($date);
        $bookings = $service->bookings()
            ->whereDate('service_time', $date)
            ->whereIsCancelled(false)
            ->orderBy('service_time')
            ->get();
        return [
            'date' => $date->format('Y-m-d'),
            'bookings' => $bookings
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Service $service
     * @param  string $date
     * @return \Illuminate\Http\Response
     */
    public function getSlots(Request $request, Service $service, $date = null)
    {
        $date = $this->validateDate($date);
        // Service schedule
        $schedule = $service->schedule ?? $service->business->schedule;
        if (!$schedule) {
            return response(['message' => 'No Schedule found'], Response::HTTP_NOT_FOUND);
        }
        $day = strtolower($date->format('D'));
        $isOpen = $schedule[$day];
        $opening = $schedule[$day . '_start'];
        $closing = $schedule[$day . '_stop'];
        if ($opening == $closing) {
            $closing = "23:59:59";
        }
        $durationInM = CarbonInterval::minutes($service->duration);
        // Service bookings
        $bookings = $service->bookings()
            ->whereDate('service_time', $date)
            ->whereIsCancelled(false)
            ->orderBy('service_time')
            ->get();
        // Prepare slots
        $slots = collect();
        if ($isOpen) {
            $period = $durationInM->toPeriod(
                $date->setTimeFromTimeString($opening),
                $date->copy()->setTimeFromTimeString($closing),
                CarbonPeriod::EXCLUDE_END_DATE
            );
            foreach ($period as $slot) {
                $slotEnd = $slot->copy()->add($durationInM);
                // check available
                $booked = $bookings->contains(function ($booking) use ($slot, $slotEnd) {
                    return $booking->service_time >= $slot && $booking->service_time < $slotEnd;
                });
                // add slot
                $slots->push([
                    'available' => !$booked,
                    'start' => $slot->format('H:i'),
                    'end' => $slotEnd->format('H:i'),
                ]);
            }
        }
        // Return slots
        return [
            'date' => $date->format('Y-m-d'),
            'isOpen' => $isOpen,
            'opening' => $opening,
            'closing' => $closing,
            'duration' => $durationInM->forHumans(),
            'slots' => $slots
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  string $date
     * @return \Carbon\CarbonImmutable|false
     */
    private function validateDate($date = null)
    {
        $data = Validator::make(['date' => $date], [
            'date' => 'nullable|date_format:Y-m-d'
        ])->validate();
        $date = $data['date'];
        return $date ? CarbonImmutable::createFromFormat('Y-m-d', $date) : CarbonImmutable::today();
    }
}
