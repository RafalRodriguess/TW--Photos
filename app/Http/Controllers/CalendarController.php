<?php

namespace App\Http\Controllers;

use Google\Client;
use Google\Service\Calendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CalendarController extends Controller
{
    public function showCalendar()
    {
        // Verifica se o token existe na sessão
        if (!Session::has('google_access_token')) {
            // Redireciona para a página de login do Google se o token não estiver presente
            return redirect()->route('google.login');
        }

        return view('agendamentos.index');
    }

    public function redirectToGoogle()
    {
        $client = $this->getClient();
        return redirect()->away($client->createAuthUrl());
    }

    public function handleGoogleCallback(Request $request)
    {
        $client = $this->getClient();

        if ($request->has('code')) {
            // Troca o código pelo token de acesso
            $client->fetchAccessTokenWithAuthCode($request->input('code'));
            $token = $client->getAccessToken();

            // Salva o token na sessão
            Session::put('google_access_token', $token);

            return redirect()->route('calendar.index');
        }

        return redirect()->route('google.login');
    }

    public function createGoogleCalendarEvent(Request $request)
    {
        // Verifique se o usuário está autenticado
        if (!Session::has('google_access_token')) {
            return response()->json(['error' => 'Usuário não autenticado'], 401);
        }
    
        $client = $this->getClient();
        $client->setAccessToken(Session::get('google_access_token'));
    
        // Verifica se o token expirou e o renova
        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            Session::put('google_access_token', $client->getAccessToken());
        }
    
        $service = new Calendar($client);
        $event = new \Google\Service\Calendar\Event([
            'summary' => $request->title,
            'description' => $request->description,
            'start' => [
                'dateTime' => date('c', strtotime($request->start_datetime)), // Formata a data corretamente
                'timeZone' => 'America/Sao_Paulo',
            ],
            'end' => [
                'dateTime' => date('c', strtotime($request->end_datetime)), // Formata a data corretamente
                'timeZone' => 'America/Sao_Paulo',
            ],
        ]);
    
        $calendarId = 'primary';
        try {
            $createdEvent = $service->events->insert($calendarId, $event);
            return response()->json(['success' => true, 'event' => $createdEvent]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao criar evento: ' . $e->getMessage()], 500);
        }
    }
    
    public function destroy($id)
{
    $event = Event::find($id);
    if ($event) {
        $event->delete();
        return response()->json(['success' => true]);
    } else {
        return response()->json(['success' => false, 'message' => 'Evento não encontrado'], 404);
    }
}
public function update(Request $request, $id)
{
    $event = Event::find($id);
    if ($event) {
        $event->title = $request->input('title');
        $event->description = $request->input('description');
        $event->start_datetime = $request->input('start_datetime');
        $event->end_datetime = $request->input('end_datetime');
        $event->color = $request->input('color');
        $event->all_day = $request->input('all_day') === 'true';

        $event->save();
        return response()->json(['success' => true]);
    } else {
        return response()->json(['success' => false, 'message' => 'Evento não encontrado'], 404);
    }
}
    public function getGoogleCalendarEvents()
    {
        if (!Session::has('google_access_token')) {
            return response()->json(['error' => 'Usuário não autenticado'], 401);
        }
    
        $client = $this->getClient();
        $client->setAccessToken(Session::get('google_access_token'));
    
        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            Session::put('google_access_token', $client->getAccessToken());
        }
    
        $service = new \Google\Service\Calendar($client);
        $calendarId = 'primary';
        $events = $service->events->listEvents($calendarId, [
            'maxResults' => 50,
            'orderBy' => 'startTime',
            'singleEvents' => true,
            'timeMin' => date('c'),
        ]);
    
        $eventList = [];
        foreach ($events->getItems() as $event) {
            $eventList[] = [
                'title' => $event->getSummary(),
                'start' => $event->getStart()->getDateTime() ?: $event->getStart()->getDate(),
                'end' => $event->getEnd()->getDateTime() ?: $event->getEnd()->getDate(),
            ];
        }
    
        return response()->json($eventList);
    }
    

    private function getClient()
    {
        $client = new Client();
        $client->setAuthConfig(env('GOOGLE_CALENDAR_CREDENTIALS_PATH'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->addScope(Calendar::CALENDAR); // Permissão para editar
        $client->setAccessType('offline');
        $client->setPrompt('consent');
    
        return $client;
    }
    
}
