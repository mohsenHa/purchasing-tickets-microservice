<?php

namespace App\Http\MicroService\OrderTicket;

use App\Exceptions\OrderTicketMicroService\TicketIsSoldOut;
use App\Exceptions\OrderTicketMicroService\TicketNotFound;
use App\Exceptions\OrderTicketMicroService\UserNotFound;
use App\Models\Ticket;
use App\Models\Tue;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * OrderTicketMicroService
 * @package App\Http\MicroService\OrderTicket
 *
 * Use this micro service for add new tue to database
 */
class OrderTicketMicroService
{

    /**
     * @param int $ticket_id
     * @param int $user_id
     * @return Tue
     * @throws TicketIsSoldOut
     * @throws TicketNotFound
     * @throws UserNotFound
     */
    public static function buyTicket(int $ticket_id, int $user_id): Tue
    {
        //start transaction
        DB::beginTransaction();

        //Lock ticket and user row
        $lockTicket = Ticket::where('id', $ticket_id)->lockForUpdate()->first();
        $lockUser = User::where('id', $user_id)->lockForUpdate()->first();

        //Check if ticket not found
        if(!$lockTicket || !($lockTicket instanceof Ticket)){
            DB::commit();
            throw new TicketNotFound('Ticket not found');
        }

        //Check if user not found
        if(!$lockUser || !($lockUser instanceof User)){
            DB::commit();
            throw new UserNotFound('User not found');
        }

        //Check if ticket capacity is ok
        if($lockTicket->c_cap === $lockTicket->t_cap){
            throw new TicketIsSoldOut('Ticket is sold out');
        }
        //Calc vat
        $vat = $lockTicket->cost * 1.09;

        //Calc total cost
        $to_cost = $lockTicket->tue->sum('cost');

        //Create new tue
        $tue = new Tue([
            'cost' => $lockTicket->cost,
            't_cap' => $lockTicket->t_cap,
            'c_cap' => $lockTicket->c_cap ,
            'vat' => $vat,
            'to_cost' => $to_cost,
        ]);

        //Assign ticket and user to tue
        $tue->ticket()->associate($lockTicket);
        $tue->user()->associate($lockUser);

        //Store changes
        $tue->save();

        //Update ticket current cap
        $lockTicket->c_cap++;

        //Store and commit and release locks
        $lockTicket->save();

        DB::commit();

        return $tue;
    }
}
