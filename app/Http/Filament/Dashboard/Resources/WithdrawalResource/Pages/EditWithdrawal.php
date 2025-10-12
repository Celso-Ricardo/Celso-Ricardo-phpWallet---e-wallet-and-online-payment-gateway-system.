<?php

namespace App\Filament\Dashboard\Resources\WithdrawalResource\Pages;

use App\Filament\Dashboard\Resources\WithdrawalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use App\Morths\Transactionable\WithdrawalActivity;

class EditWithdrawal extends EditRecord
{
    protected static string $resource = WithdrawalResource::class;

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
                        ->body('This withdrawal is already processed, so it canot be removed from the records !')
                        ->send();
                     
                    redirect($this->getResource()::getUrl('index'));

                    $this->halt();
                }

            })
            ->after(function () {
                $activity = new WithdrawalActivity();
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
                ->body('This withdrawal is already processed, so it canot be removed or updated from the records !')
                ->send();
            
            redirect($this->getResource()::getUrl('index'));

            $this->halt();
        }
    }
}
