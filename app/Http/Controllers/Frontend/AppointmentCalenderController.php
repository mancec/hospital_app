<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\Frontend\TimeSlotUpdateRequest;
use App\Models\Appointment;
use App\Models\TimeSlot;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class AppointmentCalenderController extends Controller
{
    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request, int $id)
    {

        if($request->ajax())
        {
            $data = \App\Models\TimeSlot::where('doctor_id', $id)->whereDate('start', '>=', $request->start)
                ->whereDate('end',   '<=', $request->end)
                ->get(['id', 'start', 'end']);
            return response()->json($data);
        }
        return view('appointments.weekly_calendar',['doctor' => $id]);
    }

    /**
     * @param TimeSlotUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function update(TimeSlotUpdateRequest $request, TimeSlot $timeSlot)
    {
        if($request->ajax()) {
            if ($request->type == 'update') {
                $validated = $request->validated();
                $timeSlot = $timeSlot->update($validated);
                return response()->json($timeSlot);
            }
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function action(Request $request)
    {
        if($request->ajax())
        {
            if($request->type == 'update')
            {
                $date = $request->validate([
                    'start' => 'required|date',
                    'end' => 'required|date',
                ]);
                $time = TimeSlot::find($request->id)->update($date);

                return response()->json($time);
            }

            if($request->type == 'delete')
            {
                $timeSlot = TimeSlot::find($request->id);
                if($timeSlot->status === config('enums.time_slot_status.COMPLETED'))
                {
                    $timeSlot->appointments()->delete();
                }
                $event = $timeSlot->delete();

                return response()->json($event);
            }
        }
    }
}
