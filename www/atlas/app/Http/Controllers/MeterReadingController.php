<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MeterReadingController extends Controller
{
    /**
     * Menampilkan halaman utama Meter Reading.
     */
    public function index()
    {
        return view('meter_reading.index');
    }

    /**
     * Menampilkan halaman Meter Reading CNSD.
     */
    public function cnsd()
    {
        // Pastikan nama folder Anda sesuai: meter_readingcnsd
        return view('meter_reading.meter_readingcnsd.index');
    }

    /**
     * Menampilkan halaman Meter Reading TFP.
     */
    public function tfp()
    {
        // Pastikan nama folder Anda sesuai: meter_readingtfp
        return view('meter_reading.meter_readingtfp.index');
    }

    public function cnsdKesiapan()
    {
        return view('meter_reading.meter_readingcnsd.kesiapan');
    }

    public function cnsdatis()
    {
        return view('meter_reading.meter_readingcnsd.atis');
    }
}
