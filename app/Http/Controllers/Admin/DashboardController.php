<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Event;
use App\Promo;
class DashboardController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:admin');
	}

	public function index()
	{
		$alumniMendaftar = User::where('is_active', '0')->count();
		$alumniTerdaftar = User::where('is_active', '1')->count();
		$event = Event::where('status', '0')->count();
		$promo = Promo::count();

		return view('admin.dashboard', [
			'alumniMendaftar' => $alumniMendaftar,
			'alumniTerdaftar' => $alumniTerdaftar,
			'promo'	=> $promo,
			'event' => $event,
		]);
	}
}
