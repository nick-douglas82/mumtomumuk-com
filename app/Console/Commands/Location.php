<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Site;
use Illuminate\Support\Facades\Artisan;

class Location extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:location {location}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new location giving the name of location';

    /**
     * The name of the location.
     *
     * @var string
     */
    protected $locationName = '';

    /**
     * The name of the database.
     *
     * @var string
     */
    protected $database = '';

    /**
     * The entered database username.
     *
     * @var string
     */
    protected $dbUserName = '';

    /**
     * The entered database password.
     *
     * @var string
     */
    protected $dbPassword = '';

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
     * @return mixed
     */
    public function handle()
    {
        $this->locationName = $this->argument('location');

        $this->createDatabase()
             ->insertSite()
             ->requestDBDetails();
    }


    private function createDatabase()
    {
        $this->database = $this->databaseName();

        if ( DB::statement( 'CREATE DATABASE ' . $this->database ) ) {
            $this->info('Database ' . $this->database . ' has been created!');
        }

        return $this;
    }

    private function insertSite()
    {
        Site::create([
            'name'        => $this->locationName,
            'slug'        => $this->locationSlug(),
            'img_slug'    => null,
            'activate_at' => null
        ]);

        return $this;
    }

    private function requestDBDetails()
    {
        $this->info('Please set the following details in the .env file');
        $this->info('
            DB_' . $this->createLocationAbv() . '_CONNECTION=mysql
            DB_' . $this->createLocationAbv() . '_HOST=127.0.0.1
            DB_' . $this->createLocationAbv() . '_PORT=3306
            DB_' . $this->createLocationAbv() . '_DATABASE=' . $this->databaseName() . '
            DB_' . $this->createLocationAbv() . '_USERNAME = [Enter Your Details]
            DB_' . $this->createLocationAbv() . '_PASSWORD = [Enter Your Details]
        ');

        if ( $this->confirm('Do you wish to continue?') ) {

            $this->info('Please set the following details in the config/database.php file');
            $this->info("
            '" . $this->connectionName() . "' => [
                'driver'      => 'mysql',
                'host'        => env('DB_HOST', '127.0 .0 .1'),
                'port'        => env('DB_PORT', '3306'),
                'database'    => env('DB_" . $this->createLocationAbv() . "_DATABASE', ''),
                'username'    => env('DB_" . $this->createLocationAbv() . "_USERNAME', ''),
                'password'    => env('DB_" . $this->createLocationAbv() . "_PASSWORD', ''),
                'unix_socket' => env('DB_SOCKET', ''),
                'charset'     => 'utf8mb4',
                'collation'   => 'utf8mb4_unicode_ci',
                'prefix'      => '',
                'strict'      => false,
                'engine'      => null,
            ],
            ");

            if ( $this->confirm('Do you wish to continue?') ) {
                $this->migrate();
            }

        }
    }

    public function migrate()
    {
        Artisan::call('migrate', [
            '--database' => $this->connectionName(),
            '--path'     => '/database/migrations/location/'
        ]);

        $this->info('Migrations complete!');
    }

    public function databaseName()
    {
        return str_slug($this->locationName, '_');
    }

    public function connectionName()
    {
        return str_slug($this->locationName, '');
    }

    public function locationSlug()
    {
        return str_slug($this->locationName, '-');
    }

    public function createLocationAbv()
    {
        return strtoupper(substr($this->locationName, 0, 3));
    }
}
