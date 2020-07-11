<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Contact;
use App\Models\Deal;
use App\Models\Field;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class DealController extends Controller
{

    protected $out = array();
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $active = Cookie::get('active');
        $deals = Deal::paginate(10);
        $accounts = Account::all('id', 'Account_Name')->pluck('Account_Name', 'id')->toArray();
        $contacts = Contact::all('id', 'Last_Name')->pluck('Last_Name', 'id')->toArray();
        return view('deals.index', compact('deals', 'accounts', 'contacts', 'active'));
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
        $accounts = Account::all('id', 'Account_Name', 'exid');
        $contacts = Contact::all('id', 'First_Name', 'Last_Name', 'exid');
        $fields = Field::all()->where('module', '=', 'Deals')->load('values');

        return view('deals.create', compact('users', 'accounts', 'contacts', 'fields', 'active'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' =>'required',
            'amount' =>'required|integer',
            'probability' =>'required|integer',
        ]);

        $user = User::whereId($request->get('owner'))
            ->select('exid')
            ->first()
            ->toArray();
        $account = Account::whereId($request->get('account'))
            ->select('exid')
            ->first()
            ->toArray();
        $contact = Contact::whereId($request->get('contact'))
            ->select('exid')
            ->first()
            ->toArray();

        $revenew = $request->get('amount') / $request->get('probability');

        //guzzle
        if (!isset($_COOKIE['access_token'])) return app(ConnectController::class)->updateAction('deals');
        $out['data'][] = [
            'Owner' => [
                'id' => $user['exid'],
            ],
            'Deal_Name' => $request->get('name'),
            'Stage' => $request->get('stage'),
            'Type' => $request->get('type'),
            'Lead_Source' => $request->get('source'),
            'Description' => $request->get('description'),
            'Account_Name' => [
                'id' => $account['exid'],
            ],
            'Contact_Name' => [
                'id' => $contact['exid'],
            ],
            'Expected_Revenue' => $revenew,
            'Amount' => $request->get('amount'),
            'Probability' => $request->get('probability'),
            'Created_Time' => date('Y-m-d'),
        ];
        $dealExid = app(ConnectController::class)->storeAction($out, 'Deals', 'post');


        // create deal & event
        Deal::updateOrCreate(
            [
                'Deal_Name'     => $request->get('name')
            ],
            [
                'Stage'         => $request->get('stage'),
                'Type'          => $request->get('type'),
                'Lead_Source'   => $request->get('source'),
                'Description'   => $request->get('description'),
                'Amount'        => $request->get('amount'),
                'Probability'   => $request->get('probability'),
                'Owner_exid'    => $user['exid'],
                'Contact_exid'  => $contact['exid'],
                'Account_exid'  => $account['exid'],
                'user_id'       => $request->get('owner'),
                'contact_id'    => $request->get('contact'),
                'account_id'    => $request->get('account'),
                'Expected_Revenue' => $revenew,
                'exid'          => $dealExid,
            ]
        );

        return redirect('deals')->with('success', 'Deal Saved');
    }

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
        $accounts = Account::all('id', 'Account_Name', 'exid');
        $contacts = Contact::all('id', 'First_Name', 'Last_Name', 'exid');
        $fields = Field::all()->where('module', '=', 'Deals')->load('values');

        $deal = Deal::find($id);

        return view('deals.edit', compact('deal', 'users', 'accounts', 'contacts', 'fields', 'active'));
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
            'name' =>'required',
            'amount' =>'required|integer',
            'probability' =>'required|integer',
        ]);

        $user = User::whereId($request->get('owner'))
            ->select('exid')
            ->first()
            ->toArray();
        $account = Account::whereId($request->get('account'))
            ->select('exid')
            ->first()
            ->toArray();
        $contact = Contact::whereId($request->get('contact'))
            ->select('exid')
            ->first()
            ->toArray();
        $revenew = $request->get('amount') / $request->get('probability');
        $out['data'][] = [
            'Owner' => [
                'id' => $user['exid'],
            ],
            'Deal_Name' => $request->get('name'),
            'Stage' => $request->get('stage'),
            'Type' => $request->get('type'),
            'Lead_Source' => $request->get('source'),
            'Description' => $request->get('description'),
            'Account_Name' => [
                'id' => $account['exid'],
            ],
            'Contact_Name' => [
                'id' => $contact['exid'],
            ],
            'Expected_Revenue' => $revenew,
            'Amount' => $request->get('amount'),
            'Probability' => $request->get('probability'),
        ];
        if (!isset($_COOKIE['access_token'])) return app(ConnectController::class)->updateAction('deals/edit');

        $deal = Deal::find($id);
        app(ConnectController::class)->storeAction($out, 'Deals/' . $deal->exid, 'put');

        $deal->Deal_Name     = $request->get('name');
        $deal->Stage         = $request->get('stage');
        $deal->Type          = $request->get('type');
        $deal->Lead_Source   = $request->get('source');
        $deal->Description   = $request->get('description');
        $deal->Amount        = $request->get('amount');
        $deal->Probability   = $request->get('probability');
        $deal->Owner_exid    = $user['exid'];
        $deal->Contact_exid  = $contact['exid'];
        $deal->Account_exid  = $account['exid'];
        $deal->user_id       = $request->get('owner');
        $deal->contact_id    = $request->get('contact');
        $deal->account_id    = $request->get('account');
        $deal->Expected_Revenue = $revenew;
        $deal->save();

        return redirect('/deals')->with('success', 'Deal updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $deal = Deal::find($id);
        app(ConnectController::class)->storeAction(null, 'Deals/' . $deal->exid, 'delete');
        $deal->activity()->delete();

        return redirect('deals')->with('success', 'Deal deleted!');
    }
}
