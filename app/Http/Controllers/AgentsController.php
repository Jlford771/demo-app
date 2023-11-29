<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Agent;
use App\Models\Client;

class AgentsController extends Controller
{
    public function index($clientId)
    {
        $agents = Agent::where('client_id', $clientId)->get(); 
        $client = Client::find($clientId);

        return Inertia::render('Agents', [
            'agents' => $agents,
            'clientId' => $clientId,
            'clientName' => $client ? $client->name : null,
        ]);
    }
}