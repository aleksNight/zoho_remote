<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Activity;
use App\Models\Contact;
use App\Models\Deal;
use App\Models\Field;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $active = Cookie::get('active');
        $contacts = Contact::all('id', 'Last_Name')->pluck('Last_Name', 'id')->toArray();
        $users = User::all('id', 'last_name')->pluck('last_name', 'id')->toArray();
        $records = Deal::all('id', 'Deal_Name')->pluck('Deal_Name', 'id')->toArray();
        $activities = Activity::paginate(10);

        return view('activities.index', compact('activities', 'users', 'contacts', 'records', 'active'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $active = Cookie::get('active');
        $users = User::all('id', 'first_name', 'last_name', 'exid');
        $records = Deal::all('id', 'Deal_Name');
        $contacts = Contact::all('id', 'First_Name', 'Last_Name', 'exid');
        $fields = Field::all()->where('module', '=', 'Activities')->load('values');
        //dump($fields); die();
        return view('activities.create', compact('users', 'records', 'contacts', 'fields', 'active'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'subject' =>'required',
        ]);

        $user = User::whereId($request->get('owner'))
            ->select('exid')
            ->first()
            ->toArray();
        $contact = Contact::whereId($request->get('contact'))
            ->select('exid')
            ->first()
            ->toArray();
        $record = ($request->get('record') != 0) ? Deal::whereId($request->get('record'))
            ->select('exid')
            ->first()
            ->toArray() : 0;
        $active = null;

        //guzzle
        $out['data'][] = [
            'Owner' => [
                'id' => $user['exid'],
            ],
            'Created_Time' => date("Y-m-d"),
            'Subject' => $request->get('subject'),
            'Description' => $request->get('description'),
            'Status' => $request->get('status'),
            'Priority' => $request->get('priority'),
            '$se_module' => (isset($record['exid'])) ? 'Deals' : null,
            'Who_Id' => $contact['exid'],
            'What_Id' => (isset($record['exid'])) ? $record['exid'] : null,
            'Due_Date' => now()->addDay()->toDateString(),
        ];
        if (!isset($_COOKIE['access_token'])) return app(ConnectController::class)->updateAction('ActivityController@store');
        $activityExid = app(ConnectController::class)->storeAction($out, 'Tasks', 'post');

        $activity = new Activity([
            'type' => 'Tasks',
            'subject' => $request->get('subject'),
            'created' => date('Y-m-d'),
            'description' => $request->get('description'),
            'module' => (isset($record['exid'])) ? 'Deals' : '',
            'status' => $request->get('status'),
            'priority' => $request->get('priority'),
            'contact_exid' => $contact['exid'],
            'owner_exid' => $user['exid'],
            'record_exid' => (isset($record['exid'])) ? $record['exid'] : null,
            'user_id' => $request->get('owner'),
            'contact_id'  => $request->get('contact'),
            'record_id'  => $request->get('module'),
            'exid' => $activityExid
        ]);
        $activity->save();

        return redirect('activities')->with('success', 'Activity Saved');    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $active = Cookie::get('active');
        $users = User::all('id', 'first_name', 'last_name', 'exid');
        $contacts = Contact::all('id', 'First_Name', 'Last_Name', 'exid');
        $records = Deal::all('id', 'Deal_Name');

        $fields = Field::all()->where('module', '=', 'Activities')->load('values');

        $activity = Activity::find($id);

        return view('activities.edit', compact('activity', 'users', 'contacts', 'records', 'fields', 'active'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'subject' =>'required',
        ]);

        $user = User::whereId($request->get('owner'))
            ->select('exid')
            ->first()
            ->toArray();
        $contact = Contact::whereId($request->get('contact'))
            ->select('exid')
            ->first()
            ->toArray();
        $record =  ($request->get('record') != 0) ? Deal::whereId($request->get('record'))
            ->select('exid')
            ->first()
            ->toArray() : 0;
        $active = null;

        $out['data'][] = [
            'Owner' => [
                'id' => $user['exid'],
            ],
            'Created_Time' => now(),
            'Subject' => $request->get('subject'),
            'Description' => $request->get('description'),
            'Status' => $request->get('status'),
            'Priority' => $request->get('priority'),
            '$se_module' => 'Deals',
            'Who_Id' => $contact['exid'],
            'What_Id' => (isset($record['exid'])) ? $record['exid'] : null,
        ];

        $activity = Activity::find($id);
        if (!isset($_COOKIE['access_token'])) return app(ConnectController::class)->updateAction('ActivityController@update', $id);
        app(ConnectController::class)->storeAction($out, 'Tasks/' . $activity->exid, 'put');

        $activity->subject      = $request->get('subject');
        $activity->description  = $request->get('description');
        $activity->status       = $request->get('status');
        $activity->priority     = $request->get('priority');
        $activity->Owner_exid   = $user['exid'];
        $activity->Contact_exid = $contact['exid'];
        $activity->user_id      = $request->get('owner');
        $activity->contact_id   = $request->get('contact');
        $activity->record_id    = $request->get('record');
        $activity->module       = (isset($record['exid'])) ? 'Deals' : '';
        $activity->save();

        return redirect('activities')->with('success', 'Activity updated!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!isset($_COOKIE['access_token'])) return app(ConnectController::class)->updateAction('ActivityController@destroy', $id);
        $active = null;
        $activity = Activity::find($id);
        app(ConnectController::class)->storeAction(null, 'Tasks/' . $activity->exid, 'put');

        $activity->delete();

        return redirect('activities')->with('success', 'Activity deleted!');

    }
}
