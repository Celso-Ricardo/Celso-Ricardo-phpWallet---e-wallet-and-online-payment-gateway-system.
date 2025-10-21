<?php

namespace App\Filament\Resources\Deposits\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;

use Filament\Schemas\Schema;

class DepositForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()->schema([
                    TextInput::make('gross')->label('Amount to deposit'),
                    TextInput::make('id')->label('Deposit Id')->readOnly()->disabled(),
                ]),
                Section::make('Deposit Transactin Receipt')->schema([
                    Placeholder::make('Image')
                        ->content(function ($record): HtmlString {
                            return new HtmlString("<img src= '" . Storage::url($record->transaction_receipt) . "')>");
                    })
                ])->columnSpan(1)
            ]);
    }
}
