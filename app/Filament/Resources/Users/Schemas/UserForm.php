<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->required(),
                TextInput::make('name'),
                Select::make('role')
                    ->options([
                        'customer' => 'Customer',
                        'admin' => 'Admin',
                        'super_admin' => 'Super Admin',
                    ])
                    ->required()
                    ->default('customer'),
            ]);
    }
}
