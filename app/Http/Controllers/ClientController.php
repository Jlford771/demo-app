<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::with('agents')->get();

        $clients = $clients->map(function ($client) {
            $client['formatted_created_at'] = Carbon::parse($client['created_at'])->format('m/y');
            return $client;
        });

        return response()->json(['clients' => $clients]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'type' => 'required|string' 
        ]);

        Client::create($validatedData);

        return response()->json(['message' => 'Client created successfully'], 201);
    }

    public function edit(Client $client){
        return response()->json(['client' => $client]);
    }

    public function update(Request $request, Client $client)
{
    $validatedData = $request->validate([
        'name' => 'required|string',
        'type' => 'required|string', 
    ]);

    $client->update($validatedData);

    return response()->json(['message' => 'Client updated successfully']);
}

    public function destroy(Client $client)
    {
        $client->delete();

        return response()->json(['message' => 'Client deleted successfully']);
    }

    public function getTrajectorySeries(){
        //Fetch clients grouped by type and month
        $clientsData = Client::select(
                DB::raw('MONTH(created_at) as month'),
                'type',
                DB::raw('COUNT(*) as client_count')
            )
            ->groupBy('month', 'type')
            ->get();

        $series = [];

        // Create an array for each client type then loop through last 6 months to populate series for that type
        $types = $clientsData->pluck('type')->unique();
        foreach ($types as $type) {
            $typeData = [
                'name' => $type,
                'data' => []
            ];

            for ($month = 6; $month <= 12; $month++) {
                $clientCount = $clientsData
                    ->where('type', $type)
                    ->where('month', '<=', $month)
                    ->sum('client_count');

                $typeData['data'][] = $clientCount;
            }

            $series[] = $typeData;
        }

        return response()->json(['trajectorySeries' => $series]);
    }
}