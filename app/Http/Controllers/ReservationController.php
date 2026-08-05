<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Reservation\ReservationService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userData = User::all();
        return [
            $userData
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ReservationService $reservationService)
    {
        $validateData = $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'whatsapp-number' => 'required',
            'layanan' => 'required',
            'date_picker' => 'required|date',
            'time_picker' => 'required|date_format:H:i'
        ]);

        $combinedString = $request->date_picker . ' ' . $request->time_picker;
        $formattedDateTime = Carbon::parse($combinedString)->format('Y-m-d H:i:s');

        $validateData['tanggal_penjemputan'] = $formattedDateTime;

        unset($validateData['date_picker']);
        unset($validateData['time_picker']);

        try {
            $reservation = $reservationService->create($validateData);
            $reservation->load('transaksi');

            return response()->json([
                'message' => 'Reservasi dan Transaksi berhasil dibuat',
                'data' => $reservation
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal membuat reservasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
