<?php

namespace App\Http\Controllers\pos;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function getPersons()
    {
        $persons = DB::table('Main_Persons AS p')
            ->select('p.ID','NameAr')
            ->leftJoin('Main_UsersCustomers AS uc', 'uc.CustomerID', '=', 'p.ID')
            ->where('p.PersonTypeID',1)
            // ->orWhere('p.PersonTypeID',8)
            ->get();
        return response()->json($persons);
    }


    public function getUsersWithBranches()
    {
        $users = DB::table('Main_Users')->select('Main_Users.ID', 'UserName', 'Password', 'BranchID')
            ->join('Main_UsersOfBranches', 'Main_Users.ID', '=', 'Main_UsersOfBranches.UserID')
            ->get();

        return response()->json($users);
    }
}
