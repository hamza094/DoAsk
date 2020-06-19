<?php

namespace App\Http\Controllers;

use App\Channel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        return Channel::withoutGlobalScopes()->orderby('name', 'asc')->paginate(5);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required|string',
            'color'=>'required|string',
        ]);

        $channel = Channel::create([
            'name'=>request('name'),
            'color'=>request('color')
        ]);

        cache()->forget('channels');
    }

    public function destroy($channel)
    {
        $channel = Channel::findOrFail($channel);
        $channel->delete();
        cache()->forget('channels');
    }

    public function update(Request $request, $channel)
    {
        $channel = Channel::findOrFail($channel);
        $this->validate($request, [
            'name'=>['required', Rule::unique('channels')->ignore($channel->id)],
            'archived'=>'required|boolean',
            'color'=>'required|string',

        ]);

        $channel->update(request(['name', 'archived', 'color']));

        cache()->forget('channels');
    }
}
