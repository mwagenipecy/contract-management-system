<?php

namespace App\Http\Controllers;

use App\Models\ReminderItem;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    public function index()
    {
        // Logic to display the list of reminders
        return view('pages.reminder.index');
    }


    public function create(){

        // Logic to show the form for creating a new reminder
        return view('pages.reminder.create');
    }


    public function reminderSetting(){

        return view('pages.reminder.setting');
    }



    public function show(){


        return view('pages.reminder.setting');
    }



    public function view($id){



        $reminder=ReminderItem::findOrFail($id);

        return view('pages.reminder.show', [
            'reminder' => $reminder
        ]);
    }







}
