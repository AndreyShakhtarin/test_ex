<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('User Details')->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('email')
                        ->email()
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),
                    TextInput::make('password')
                        ->password()
                        ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                        ->dehydrated(fn ($state) => filled($state))
                        ->required(fn (string $operation) => $operation === 'create')
                        ->maxLength(255),
                ]),
                Section::make('Profile')->schema([
                    TextInput::make('profile.bio')
                        ->label('Bio')
                        ->maxLength(255),
                    TextInput::make('profile.phone')
                        ->label('Phone')
                        ->maxLength(20),
                    TextInput::make('profile.website')
                        ->label('Website')
                        ->url()
                        ->maxLength(255),
                ]),
            ]);
    }
}
