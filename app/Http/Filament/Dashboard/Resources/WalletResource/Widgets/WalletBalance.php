<?php

namespace App\Filament\Dashboard\Resources\WalletResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Wallet;

class WalletBalance extends BaseWidget
{
    protected function getStats(): array
    {

        $wallets = Wallet::with(['currency'])->where('user_id', auth()->user()->id)->get();
        $cardsArray = [];
        
        if(count($wallets) > 0){
            foreach($wallets as $wallet)
            {
                array_push($cardsArray, Card::make($wallet->currency->name, $wallet->amount));
            }

            return $cardsArray;
        }
        return [
            
        ];
    }
}
