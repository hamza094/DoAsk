<?php

namespace App\Http\Controllers;

use App\Channel;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Channel $channel)
    {
        return view('admin.channels.index');
    }

    public function show()
    {
        return Channel::latest()->paginate(5);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required|string',
        ]);

        $channel = Channel::create([
           'name'=>request('name'),
           ]);
    }

    public function destroy($channel)
    {
        $channel = Channel::findOrFail($channel);
        $channel->delete();
    }

    public function update(Request $request, $channel)
    {
        $channel = Channel::findOrFail($channel);
        $this->validate($request, [
            'name'=>'required|string',
        ]);

        $channel->update(request(['name']));
    }
}
