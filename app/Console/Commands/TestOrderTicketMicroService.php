<?php

namespace App\Console\Commands;

use App\Http\MicroService\OrderTicket\OrderTicketMicroService;
use Illuminate\Console\Command;

class TestOrderTicketMicroService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:ticket {user_id} {ticket_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add ticket parameters user_id , ticket_id';

    /**
     * Execute the console command.
     *
     * @void
     */
    public function handle()
    {
        //Get user id from argument
        $user_id = $this->argument('user_id');

        //Get ticket id from argument
        $ticket_id = $this->argument('ticket_id');

        //Run microservice to add tue and return created tue id
        return OrderTicketMicroService::buyTicket($user_id, $ticket_id)->id;
    }
}
