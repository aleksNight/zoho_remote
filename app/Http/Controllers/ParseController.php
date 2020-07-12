<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Activity;
use App\Models\Contact;
use App\Models\Deal;
use App\Models\Field;
use App\Models\FieldValue;
use App\Models\Module;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ParseController extends Controller
{
    //
    public function index ()
    {
        if (!isset($_COOKIE['access_token'])) return app(ConnectController::class)->updateAction('ParseController@index');
        $active = Cookie::get('active');
        return(view('parsing', compact('active')));
    }

    public function allLookup ()
    {
        if (!isset($_COOKIE['access_token'])) return app(ConnectController::class)->updateAction('ParseController@allLookup');

        $this->getUsers();
        $this->getModules();
        $this->getAccounts();
        $this->getContacts();
        return redirect('parser')->with('status', 'Lookups updated successfuly!');
    }

    public function allRecords ()
    {
        if (!isset($_COOKIE['access_token'])) return app(ConnectController::class)->updateAction('ParseController@allRecords');

        $this->getDeals();
        $this->getActivities();
        return redirect('parser')->with('status', 'Records updated successfuly!');
    }

    public function fields ()
    {
        if (!isset($_COOKIE['access_token'])) return app(ConnectController::class)->updateAction('ParseController@fields');

        $this->getFields('Deals');
        $this->getFieldValues('Deals');
        $this->getFields('Activities');
        $this->getFieldValues('Activities');
        return redirect('parser')->with('status', 'Fields updated successfuly!');
    }

    public function getUsers()
    {
        $result = app(ConnectController::class)->getAction('users');

        foreach ($result as $key => $val) {
            User::updateOrCreate(
            [
                'exid'          => $val['id'],
            ],
            [
                'first_name'    => $val['first_name'],
                'last_name'     => $val['last_name'],
                'email'         => $val['email'],
                'zip'           => &$val['zip'],
                'website'       => &$val['website'],
                'time_zone'     => &$val['time_zone'],
                'password'      => Hash::make(Str::random(8))
            ]);
        }
    }

    public function getContacts ()
    {
        $result = app(ConnectController::class)->getAction('Contacts');

        foreach ($result as $key => $val) {
            Contact::updateOrCreate(
            [
                'exid'          => $val['id'],
            ],
            [
                'First_Name'      => &$val['First_Name'],
                'Last_Name'       => &$val['Last_Name'],
                'Email'           => &$val['Email'],
                'Lead_Source'     => $val['Lead_Source'],
                'Mailing_Country' => $val['Mailing_Country'],
                'Department'      => $val['Department'],
                'Mailing_Zip'     => $val['Mailing_Zip'],
                'Twitter'         => $val['Twitter'],
                'Mailing_Street'  => $val['Mailing_Street'],
                'Skype_ID'        => $val['Skype_ID'],
                'Phone'           => $val['Phone'],
                'Mailing_City'    => $val['Mailing_City'],
                'Title'           => $val['Title'],
                'Mobile'          => $val['Mobile'],
            ]);
        }
    }

    public function getAccounts ()
    {
        $result = app(ConnectController::class)->getAction('Accounts');

        foreach ($result as $key => $val) {
            Account::updateOrCreate(
            [
                'exid'              => $val['id'],
            ],
            [
                'Annual_Revenue'    => $val['Annual_Revenue'],
                'Employees'         => $val['Employees'],
                'Ownership'         => &$val['Ownership'],
                'Description'       => &$val['Description'],
                'Account_Name'      => $val['Account_Name'],
                'Account_Type'      => &$val['Account_Type'],
                'Website'           => &$val['Website'],
                'Industry'          => $val['Industry'],
                'Phone'             => $val['Phone'],
                'Billing_Country'   => $val['Billing_Country'],
                'Billing_Street'    => $val['Billing_Street'],
                'Billing_Code'      => $val['Billing_Code'],
                'Billing_City'      => $val['Billing_City'],
                'Billing_State'     => $val['Billing_State'],
            ]);
        }
    }

    public function getDeals ()
    {
        $result = app(ConnectController::class)->getAction('Deals');

        foreach ($result as $key => $val) {
            $userId = User::whereExid($val['Owner']['id'])
                ->select('id')
                ->first()
                ->toArray();
            if (!is_null($val['Account_Name'])) {
                $accountId = Account::whereExid($val['Account_Name']['id'])
                    ->select('id')
                    ->first()
                    ->toArray();
            }
            if (!is_null($val['Account_Name'])) {
                $contactId = Contact::whereExid($val['Contact_Name']['id'])
                    ->select('id')
                    ->first()
                    ->toArray();
            }
            Deal::updateOrCreate(
                [
                    'Deal_Name'         => $val['Deal_Name'],
                ],
                [
                    'exid'              => $val['id'],
                    'Owner_exid'        => $val['Owner']['id'],
                    'Stage'             => $val['Stage'],
                    'Type'              => $val['Type'],
                    'Lead_Source'       => &$val['Lead_Source'],
                    'Description'       => &$val['Description'],
                    'Account_exid'      =>  $val['Account_Name']['id'],
                    'Account_name'      =>  $val['Account_Name']['name'],
                    'Contact_exid'      => $val['Contact_Name']['id'],
                    'Contact_name'      => $val['Contact_Name']['name'],
                    'Expected_Revenue' =>  $val['Expected_Revenue'],
                    'Amount'            => $val['Amount'],
                    'Probability'       => $val['Probability'],
                    'created_at'        => $val['Created_Time'],
                    'user_id'           => $userId['id'],
                    'contact_id'        => $contactId['id'],
                    'account_id'        => $accountId['id'],
                ]
            );
        }

    }

    public function getActivities ()
    {
        $result = app(ConnectController::class)->getAction('Activities');

        foreach ($result as $key => $val) {
            $user = User::whereExid($val['Owner']['id'])
                ->select('id')
                ->first()
                ->toArray();
            if ($val['$se_module'] == 'Deals' && is_array($val['What_Id'])){
                $module = strtolower($val['$se_module']);
                $record = DB::select('SELECT `id` FROM `' . $module . '` WHERE `exid` = ?', [$val['What_Id']['id']]);
                $record = reset($record);
            }
            if (is_array($val['Who_Id'])) {
                $contact = DB::select('SELECT `id` FROM `contacts` WHERE `exid` = ?', [$val['Who_Id']['id']]);
                $contact = reset($contact);
            }

            Activity::updateOrCreate([
                'exid'          => $val['id'],
            ],
            [
                'description'   => &$val['Description'],
                'type'          => &$val['Activity_Type'],
                'created'       => &$val['Created_Time'],
                'closed'        => &$val['Closed_Time'],
                'subject'       => $val['Subject'],
                'module'        => &$val['$se_module'],
                'status'        => $val['Status'],
                'priority'      => $val['Priority'],
                'owner_exid'    => &$val['Owner']['id'],
                'contact_exid'  => &$val['Who_Id']['id'],
                'record_exid'   => &$val['What_id']['id'],
                'user_id'       => $user['id'],
                'record_id'     => isset($record->id) ? $record->id : null,
                'contact_id'    => isset($contact->id) ? $contact->id : null,
            ]);
        }
    }

    public function getModules ()
    {
        $result = app(ConnectController::class)->getAction('settings/modules');

        foreach ($result as $key => $val) {
            Module::updateOrCreate(
            [
                'exid'          => $val['id'],
            ],
            [
                'module'        => $val['api_name'],
                'plural_label'  => $val['plural_label'],
                'singular_label' => $val['singular_label'],
            ]);
        }
    }

    public function getFields ($module)
    {
        $result = app(ConnectController::class)->getAction('settings/fields?module=' . $module);

        foreach ($result as $key => $val) {
            if (isset($val['pick_list_values'][0])) {
                Field::updateOrCreate(
                [
                    'exid'          => $val['id'],
                ],
                [
                    'api_name'      => $val['api_name'],
                    'field_label'   => $val['field_label'],
                    'display_label' => $val['display_label'],
                    'module'        => $module
                ]);
            }
        }
    }

    public function getFieldValues ($module)
    {
        $uri = '/settings/fields?module=' . $module;
        $result = app(ConnectController::class)->getAction('settings/fields?module=' . $module);

        foreach ($result as $key => $val) {
            if (isset($val['pick_list_values'][0])) {
                foreach ($val['pick_list_values'] as $pick) {
                    $fieldId = Field::whereExid($val['id'])
                        ->select('id')
                        ->first()
                        ->toArray();

                    FieldValue::updateOrCreate(
                    [
                        'field_id'          => $fieldId['id'],
                        'actual_value'      => $pick['actual_value'],
                    ],
                    [
                        'display_value'     => $pick['display_value'],
                        'forecast_category' => &$pick['forecast_category'],
                        'module'            => $module
                    ]);
                }
            }
        }
    }

}
