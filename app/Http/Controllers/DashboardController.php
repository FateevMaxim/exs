<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\ClientTrackList;
use App\Models\Configuration;
use App\Models\Message;
use App\Models\TrackList;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index ()
    {
        $config = Configuration::query()->select('address', 'title_text', 'address_two')->first();
        $cities = City::query()->select('title')->get();
        if (Auth::user()->is_active === 1 && Auth::user()->type === null){
            $tracks = ClientTrackList::query()
                ->leftJoin('track_lists', 'client_track_lists.track_code', '=', 'track_lists.track_code')
                ->select('client_track_lists.track_code', 'client_track_lists.detail', 'client_track_lists.created_at', 'client_track_lists.id',
                    'track_lists.to_china', 'track_lists.to_almaty', 'track_lists.to_client', 'track_lists.to_city',
                    'track_lists.city', 'track_lists.to_client_city', 'track_lists.client_accept', 'track_lists.status')
                ->where('client_track_lists.user_id', Auth::user()->id)
                ->where('client_track_lists.status', null)
                ->orderByDesc('client_track_lists.id')
                ->get();
            $count = count($tracks);

            $messages = Message::all();

            return view('dashboard')->with(compact('tracks', 'count', 'messages', 'config'));
        }elseif (Auth::user()->is_active === 1 && Auth::user()->type === 'stock'){
            $count = TrackList::query()->whereDate('to_china', Carbon::today())->count();
            return view('stock')->with(compact('count', 'config'));
        }elseif (Auth::user()->is_active === 1 && Auth::user()->type === 'almatyin'){
            $count = TrackList::query()->whereDate('to_almaty', Carbon::today())->count();
            return view('almaty', ['count' => $count, 'config' => $config, 'cityin' => 'Алматы']);
        }elseif (Auth::user()->type === 'atyrauin') {
            $count = TrackList::query()->whereDate('to_city', Carbon::today())->where('status', 'Получено на складе в Атырау')->count();
            return view('almaty', ['count' => $count, 'config' => $config, 'cityin' => 'Атырау']);
        }elseif (Auth::user()->is_active === 1 && Auth::user()->type === 'almatyout'){
            $count = TrackList::query()->whereDate('to_client', Carbon::today())->count();
            return view('almatyout', ['count' => $count, 'config' => $config, 'cityin' => 'Алматы']);
        }elseif (Auth::user()->type === 'atyrauout') {
            $count = TrackList::query()->whereDate('to_client_city', Carbon::today())->count();
            return view('almatyout', ['count' => $count, 'config' => $config, 'cityin' => 'Атырау']);
        }elseif (Auth::user()->is_active === 1 && Auth::user()->type === 'othercity'){
            $count = TrackList::query()->whereDate('to_client', Carbon::today())->count();
            return view('othercity')->with(compact('count', 'config', 'cities'));
        }elseif (Auth::user()->is_active === 1 && Auth::user()->type === 'admin'){
            $messages = Message::all();
            $config = Configuration::query()->select('address')->first();
            $search_phrase = '';
            $users = User::query()->select('id', 'name', 'surname', 'type', 'login', 'city', 'is_active', 'block', 'password', 'created_at', 'branch')->where('type', null)->where('is_active', false)->get();
            return view('admin')->with(compact('users', 'messages', 'search_phrase', 'config'));
        }
        return view('register-me')->with(compact( 'config'));
    }

    public function archive ()
    {
            $tracks = ClientTrackList::query()
                ->leftJoin('track_lists', 'client_track_lists.track_code', '=', 'track_lists.track_code')
                ->select( 'client_track_lists.track_code', 'client_track_lists.detail', 'client_track_lists.created_at',
                    'track_lists.to_china','track_lists.to_almaty','track_lists.to_client','track_lists.client_accept','track_lists.status')
                ->where('client_track_lists.user_id', Auth::user()->id)
                ->where('client_track_lists.status', '=', 'archive')
                ->get();
        $config = Configuration::query()->select('address', 'title_text', 'address_two')->first();
            $count = count($tracks);
            return view('dashboard')->with(compact('tracks', 'count', 'config'));
    }



}
