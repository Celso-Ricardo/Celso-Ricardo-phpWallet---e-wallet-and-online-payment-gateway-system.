<?php

namespace App\Filament\Dashboard\Resources\DepositResource\Pages;

use App\Filament\Dashboard\Resources\DepositResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use App\Morths\Transactionable\DepositActivity;

class EditDeposit extends EditRecord
{
    protected static string $resource = DepositResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
            ->before(function () {
                if($this->record->transaction_state_id != 3){
                    Notification::make()
                        ->danger()
                        ->title("Danger !")
                        ->color('danger')
                        ->duration(5000)
                        ->body('This deposit is already processed, so it canot be removed from the records !')
                        ->send();

                    $this->halt();
                }

            })
            ->after(function () {
                $activity = new DepositActivity();
                $activity->removeActivity($this->record);
            }),
        ];
    }

    protected function beforeSave(): void
    {
        if (auth()->user()->id != $this->record->user_id)
        {
            redirect($this->getResource()::getUrl('index'));
        }
        if($this->record->transaction_state_id != 3){
            Notification::make()
                ->danger()
                ->title("Danger !")
                ->color('danger')
                ->duration(5000)
                ->body('This deposit is already processed, pease make a new deposit !')
                ->send();
            $this->halt();
        }
        
    }
}
