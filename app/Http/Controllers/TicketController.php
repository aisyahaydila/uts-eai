<?php

namespace App\Http\Controllers;

use App\Models\Tickets;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $ticket = Tickets::all();
        return response()->json(['ticket' => $ticket], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required']);
        $ticket = new Tickets();
        $ticket->title = $request->title;
        $ticket->description = $request->description;
        $ticket->status = 'Open';
        $ticket->save();
        return response()->json(['ticket' => $ticket], 201);
    }


    public function show($id)
    {
        $ticket = Tickets::find($id);
        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }
        return response()->json(['ticket' => $ticket], 200);
    }


    public function update(Request $request, $id)
    {
        $ticket = Tickets::find($id);
        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }
        $ticket->title = $request->title;
        $ticket->description = $request->description;
        $ticket->status = $request->status ? $request->status : $ticket->status;
        $ticket->save();
        return response()->json(['ticket' => $ticket], 200);
    }


    public function destroy($id)
    {
        $ticket = Tickets::find($id);
        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }
        $ticket->delete();
        return response()->json(['message' => 'Ticket deleted successfully'], 200);
    }


    public function search($keyword)
    {
        $ticket = Tickets::where('name', 'like', '%' . $keyword . '%')
            ->orWhere('description', 'like', '%' . $keyword . '%')
            ->get();
        if ($ticket->isEmpty()) {
            return response()->json(['message' => 'No tickets found'], 404);
        }
        return response()->json($ticket, 200);
    }
}