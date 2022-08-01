<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use App\Models\Tue;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * CheckTueTable
 * @package App\Console\Commands
 */
class CheckTueTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:tue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Job for checks the TUE every 1 hour and re-calculates the TCap and CCap and ToCost';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //Select all tickets
        $allTickets = Ticket::all();

        foreach ($allTickets as $ticket){

            //Start db transaction
            DB::beginTransaction();

            //Lock ticket row
            $lockTicket = Ticket::where('id', $ticket->id)->lockForUpdate()->first();

            //Calc total cost in order to tues
            $to_cost = 0;
            $c_cap = 0;

            foreach ($lockTicket->tue as $tue){
                if($tue instanceof Tue){

                    //Update tues total cost and current cap on tue
                    $tue->to_cost = $to_cost;
                    $tue->c_cap = $c_cap;
                    $tue->save();

                    //Update parameters
                    $to_cost += $tue->cost;
                    $c_cap++;
                }
            }

            //Update ticket row
            $lockTicket->c_cap = $c_cap;
            $lockTicket->save();

            //Commit changes and release row lock
            DB::commit();
        }
        return 0;
    }
}
