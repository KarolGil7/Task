<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\UserAddresse;
use App\Models\UserCompany;
use Illuminate\Support\Facades\Hash;

class getUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:getUsers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Downloading users from the API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {

            $response = Http::get('https://jsonplaceholder.typicode.com/users');
            $data = $response->json();

            foreach ($data as $key => $value) {
                
                $rowUser = User::getById($value["id"]);
                if ($rowUser == null) 
                {
                    $user = new User();
                    $user->id = $value["id"];
                    $user->name = $value["name"];
                    $user->username = $value["username"];
                    $user->email = $value["email"];
                    $user->phone = $value["phone"];
                    $user->website = $value["website"];
                    $user->password = Hash::make(User::generateRandomString());

                    DB::transaction(function () use ($user) {
                        $user->save();
                    });
                }
                else
                {
                    $userToSave = [];
                    $userToSave["name"] = $value["name"];
                    $userToSave["username"] = $value["username"];
                    $userToSave["email"] = $value["email"];
                    $userToSave["phone"] = $value["phone"];
                    $userToSave["website"] = $value["website"];

                    DB::transaction(function () use ($value, $userToSave) {
                        User::where('id', '=', $value["id"])->update($userToSave);
                    });
                }

                $rowUserAddresse = UserAddresse::getByUserId($value["id"]);
                if ($rowUserAddresse == null) 
                {
                    $userAddresse = new UserAddresse();
                    $userAddresse->user_id = $value["id"];
                    $userAddresse->street = $value["address"]["street"];
                    $userAddresse->suite = $value["address"]["suite"];
                    $userAddresse->city = $value["address"]["city"];
                    $userAddresse->zipcode = $value["address"]["zipcode"];
                    $userAddresse->lat = $value["address"]["geo"]["lat"];
                    $userAddresse->lng = $value["address"]["geo"]["lng"];

                    DB::transaction(function () use ($userAddresse) {
                        $userAddresse->save();
                    });
                }
                else
                {
                    $userAddresseToSave = [];
                    $userAddresseToSave["street"] = $value["address"]["street"];
                    $userAddresseToSave["suite"] = $value["address"]["suite"];
                    $userAddresseToSave["city"] = $value["address"]["city"];
                    $userAddresseToSave["zipcode"] = $value["address"]["zipcode"];
                    $userAddresseToSave["lat"] = $value["address"]["geo"]["lat"];
                    $userAddresseToSave["lng"] = $value["address"]["geo"]["lng"];

                    DB::transaction(function () use ($value, $userAddresseToSave) {
                        UserAddresse::where('user_id', '=', $value["id"])->update($userAddresseToSave);
                    });
                }
                
                $rowUserCompany = UserCompany::getByUserId($value["id"]);
                if ($rowUserCompany == null) 
                {
                    $userCompany = new UserCompany();
                    $userCompany->user_id = $value["id"];
                    $userCompany->name = $value["company"]["name"];
                    $userCompany->catchPhrase = $value["company"]["catchPhrase"];
                    $userCompany->bs = $value["company"]["bs"];

                    DB::transaction(function () use ($userCompany) {
                        $userCompany->save();
                    });
                }
                else
                {
                    $userAddresseToSave = [];
                    $userCompanyToSave["name"] = $value["company"]["name"];
                    $userCompanyToSave["catchPhrase"] = $value["company"]["catchPhrase"];
                    $userCompanyToSave["bs"] = $value["company"]["bs"];

                    DB::transaction(function () use ($value, $userCompanyToSave) {
                        UserCompany::where('user_id', '=', $value["id"])->update($userCompanyToSave);
                    });
                }

                DB::commit();
            }
            echo  "cron - getUsers - success";
        } catch (Exception $e) {
            DB::rollBack();
            Log::debug($e->getMessage());
            echo  "cron - getUsers - error";
        }
        return 0;
    }
}
